<?php

namespace JCV\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {

        return $this->render('JCVCoreBundle:Default:index.html.twig');
    }

    public function contactAction(Request $request) {

        $request->getSession()->getFlashBag()->add(
                'notice', 'Contact page not available yet!'
        );
        return $this->redirect($this->generateUrl('jcv_core_homepage'));
    }
    private function getAdverts($limit = null) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('JCVAdvertBundle:Advert');
        $listAdverts = $repository->getAdverts($limit);
        return $listAdverts;
    }

}
