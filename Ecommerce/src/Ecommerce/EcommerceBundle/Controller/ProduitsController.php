<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Entity\Produits;

class ProduitsController extends Controller
{
    public function produitsAction()
    {
        return $this->render('EcommerceBundle:Produits:produits.html.twig');
    }

    public function presentationAction()
    {
        return $this->render('EcommerceBundle:Produits:presentation.html.twig');
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
