<?php
namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Ecommerce\EcommerceBundle\Entity\UsersAdresses;
use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Entity\Produits;
use Symfony\Component\HttpFoundation\Request;

class CommandesController extends Controller
{

    public function facture(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $generator = $this->container->get('security.secure_random');
        $session = $request->getSession();
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commandeProduits = array();
        $totalHT = 0;
        $totalTTC = 0;

        $facturation = $em->getRepository('EcommerceBundle:UsersAdresses')->find($adresse['facturation']);
        $livraison = $em->getRepository('EcommerceBundle:UsersAdresses')->find($adresse['livraison']);
        $produits = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));

        foreach($produits as $produit)
        {
            $prixHT = ($produit->getPrix() * $panier[$produit->getId()]);
            $prixTTC = ($produit->getPrix() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicate());
            $totalHT += $prixHT;
            $totalTTC += $prixTTC;

            if (!isset($commandeProduits['tva']['%'.$produit->getTva()->getValeur()]))
                $commandeProduits['tva']['%'.$produit->getTva()->getValeur()] = round($prixTTC - $prixHT,2);
            else
                $commandeProduits['tva']['%'.$produit->getTva()->getValeur()] += round($prixTTC - $prixHT,2);

            $commandeProduits['produit'][$produit->getId()] = array('reference' => $produit->getNom(),
                'quantite' => $panier[$produit->getId()],
                'prixHT' => round($produit->getPrix(),2),
                'prixTTC' => round($produit->getPrix() / $produit->getTva()->getMultiplicate(),2));
        }
        $commandeProduits['livraison'] = array('prenom' => $livraison->getPrenom(),
            'nom' => $livraison->getNom(),
            'telephone' => $livraison->getTelephone(),
            'adresse' => $livraison->getAdresse(),
            'cp' => $livraison->getCp(),
            'ville' => $livraison->getVille(),
            'pays' => $livraison->getPays(),
            'complement' => $livraison->getComplement());
        $commandeProduits['facturation'] = array('prenom' => $facturation->getPrenom(),
            'nom' => $facturation->getNom(),
            'telephone' => $facturation->getTelephone(),
            'adresse' => $facturation->getAdresse(),
            'cp' => $facturation->getCp(),
            'ville' => $facturation->getVille(),
            'pays' => $facturation->getPays(),
            'complement' => $facturation->getComplement());
        $commandeProduits['prixHT'] = round($totalHT,2);
        $commandeProduits['prixTTC'] = round($totalTTC,2);
        $commandeProduits['token'] = bin2hex($generator->nextBytes(20));
        return $commandeProduits;
    }

    public function prepareCommandeAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        if (!$session->has('commande'))
            $commande = new Commandes();
        else
            $commande = $em->getRepository('EcommerceBundle:Commandes')->find($session->get('commande'));

        $commande->setDate(new \DateTime());
        $commande->setUser($this->getUser());
        $commande->setValider(0);
        $commande->setReference(0);
        $commande->setproduits($this->facture($request));

        if (!$session->has('commande')) {
            $em->persist($commande);
            $session->set('commande',$commande);
        }

        $em->flush();

        return new Response($commande->getId());
    }

    /* a remplacer par l'api banque */
    public function validationCommandeAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('EcommerceBundle:Commandes')->find($id);

        if (!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas ou deja validée');

        $commande->setValider(1);
        $commande->setReference(1); //Service
        $em->flush();

        $session = $request->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');

        $this->get('session')->getFlashBag()->add('success','Votre commande a été validée avec succès');
        return $this->redirect($this->generateUrl('produits'));
    }
}