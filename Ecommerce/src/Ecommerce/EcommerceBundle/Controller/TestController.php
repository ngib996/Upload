<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Ecommerce\EcommerceBundle\Form\testType;

class TestController extends Controller
{
    public function testFormulaireAction(Request $request)
    {
        $form = $this->createForm(new testType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            var_dump($form->getData());
            $form = $this->createForm(new testType(), array('email' => 'test@test.be'));
        }

//        if ($this->get('request')->getMethod() == 'POST') {
//            $form->bind($this->get('request'));
//            var_dump($form->getData());
//
//
//            $form = $this->createForm(new testType(), array('email' => 'test@devandclick.fr', ''));
//        }

        return $this->render('EcommerceBundle::test.html.twig', array('form' => $form->createView()));
    }
}