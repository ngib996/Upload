<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller
{

    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('EcommerceBundle:Categories')->findAll();

        return $this->render('EcommerceBundle:Categories:menu.html.twig', array('categories' => $categories));
    }
//    public function pageAction($id)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $page = $em->getRepository('PagesBundle:Pages')->find($id);
//        if (!$page) throw $this->createNotFoundException('La page n\'existe pas.');
//        return $this->render('PagesBundle:Pages:pages.html.twig', array('page' => $page));
//    }
}
