<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Entity\Produits;
use Ecommerce\EcommerceBundle\Form\RechercheType;
use Symfony\Component\HttpFoundation\Request;


class ProduitsController extends Controller
{
    public function rechercheAction()
    {
        $form = $this->createForm(new RechercheType());
        return $this->render('EcommerceBundle:Produits:recherche.html.twig', array('form' => $form->createView()));
    }

    public function rechercheTraitementAction(Request $request)
    {
        $form = $this->createForm(new RechercheType());
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $produits = $em->getRepository('EcommerceBundle:Produits')->recherche($form['recherche']->getData());
        } else {
            throw $this->createNotFoundException('Problem.');
        }

        return $this->render('EcommerceBundle:Produits:produits.html.twig', array('produits' => $produits));
    }

    public function produitsAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EcommerceBundle:Produits')->findBy(array('disponible' => 1));

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        return $this->render('EcommerceBundle:Produits:produits.html.twig',array('produits' => $produits,
                                                                                'panier' => $panier));
    }

    public function categoryProduitsAction($category)
    {

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EcommerceBundle:Produits')->byCategory($category);

        return $this->render('EcommerceBundle:Produits:produits.html.twig',array('produits' => $produits));
    }
    public function presentationAction($id,Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EcommerceBundle:Produits')->find($id);

        if (!$produit) throw $this->createNotFoundException('La page n\'existe pas.');

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        return $this->render('EcommerceBundle:Produits:presentation.html.twig',array('produit' => $produit,
                                                                                    'panier' => $panier));
    }

    public function addAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produit = new Produits();
        $produit->setNom("Tomate");
        $produit->setDescription("Ceci est une tomate");
        $produit->setPrix("0.99");
        $produit->setDisponible(true);
        $produit->setCategorie("Légumes");
        $produit->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNmznWYB0QYSrjOCyIYwTTVUPYv0ChtVdK8R0cKmWh6BBZzkf0fw");
        $produit->setTva("21");

        $em->persist($produit);


        $em->flush();


        die("ici");
    }

}
