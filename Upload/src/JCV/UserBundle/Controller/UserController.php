<?php

namespace JCV\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JCV\UserBundle\Entity\User;
use JCV\UserBundle\Form\Type\UserType;
use JCV\UserBundle\Form\Type\UserEditType;

class UserController extends Controller {

    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $em->getRepository('JCVUserBundle:User');
        $listUsers = $repositoryUser->getUsers();

        return $this->render('JCVUserBundle:User:index.html.twig',array('listUsers' => $listUsers));
    }

    public function viewAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $em->getRepository('JCVUserBundle:User');

        $user=$repositoryUser->find($id);

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id " . $id . " n'existe pas.");
        }

        return $this->render('JCVUserBundle:User:view.html.twig', array('user' => $user,));
    }

    public function addAction(Request $request) {

         if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux administrateurs.');
        }

        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setSalt('test');
        $form = $this->createForm(new UserType(), $user);
        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $user contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // Si on n'est pas en POST, alors on affiche le formulaire
        //if ($request->isMethod('POST')) {
        if ($form->isValid()) {
            $user->getImage()->upload();
            $user->getImage()->resize();
            $em->persist($user);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'User bien enregistré.');

            // Puis on redirige vers la page de visualisation de cettte annonce
            return $this->redirect($this->generateUrl('jcv_user_view', array('id' => $user->getId())));
        }
        return $this->render('JCVUserBundle:User:add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request) {

         if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux administrateurs.');
        }

        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $em->getRepository('JCVUserBundle:User');


        $user = $repositoryUser->find($id);

        $editedUrl=$user->getImage()->getUrl();

// il plante ici
        $form = $this->createForm(new UserEditType($user), $user);



        $form->handleRequest($request);

        if ($form->isValid()) {

            $user->getImage()->upload($editedUrl);
            $user->getImage()->resize();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');

            // Puis on redirige vers la page de visualisation de cettte annonce
            return $this->redirect($this->generateUrl('jcv_user_view', array('id' => $user->getId())));
        }

        return $this->render('JCVUserBundle:User:edit.html.twig', array('user' => $user, 'form' => $form->createView()));
    }

    public function deleteAction($id, Request $request) {

         if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux administrateurs.');
        }

        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $em->getRepository('JCVUserBundle:User');
       // $repositoryCategory = $em->getRepository('JCVUserBundle:Category');

        $user = $repositoryUser->find($id);
        $lifePartners = $repositoryUser->getUserHavingLivePartner($user);
        foreach ($lifePartners as $lifePartner) {
            var_dump($lifePartner->getId());
            $lifePartner->setLifePartner();
        }


        $em->remove($user);
        //$user->getImage()->removeFile();

//        $listCategories = $repositoryCategory->findAll();
//        foreach ($listCategories as $category) {
//            $user->removeCategory($category);
//        }
        // pas de persist car User est récupéré par Doctrine, donc il le connait!
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'User bien supprimé.');

        return $this->redirect($this->generateUrl('jcv_user_home'));
    }

//    public function menuAction() {
//        $listUsers = $this->getUsers(3);
//
//        return $this->render('JCVUserBundle:User:menu.html.twig', array(
//                    // Tout l'intérêt est ici : le contrôleur passe
//                    // les variables nécessaires au template !
//                    'listUsers' => $listUsers
//        ));
//    }

    private function getUsers($limit=null) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('JCVUserBundle:User');
        $listUsers = $repository->getUsers($limit);
        return $listUsers;
    }

}
