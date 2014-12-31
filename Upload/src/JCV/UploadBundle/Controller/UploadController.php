<?php

namespace JCV\UploadBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JCV\UploadBundle\Entity\Upload;
use JCV\UploadBundle\Form\UploadType;
use JCV\UploadBundle\Form\Type\UploadEditType;
use JCV\UploadBundle\Form\Type\UploadSelectByIdType;

/**
 * Upload controller.
 *
 */
class UploadController extends Controller
{

    /**
     * Lists all Upload entities.
     *
     */
    public function indexAction(Request $request,$page = 1)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }
        $nbPerPage = $this->container->getParameter('nbPerPage');
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JCVUploadBundle:Upload')->getUploads($page, $nbPerPage);
        $form = $this->createForm(new UploadSelectByIdType())->createView();

        $nbPages = ceil(count($entities) / $nbPerPage);
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        return $this->render('JCVUploadBundle:Upload:index.html.twig', array(
            'entities' => $entities,
            'nbPages' => $nbPages,
            'page' => $page,
            'form' => $form,
        ));
    }
    /**
     * Creates a new Upload entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Upload();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $entity->file->move(__DIR__.'/../../../../web/uploads/xml', $entity->file->getClientOriginalName());
//            $entity->setUploadFile($entity->file->getClientOriginalName());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('upload_show', array('id' => $entity->getId())));
        }

        return $this->render('JCVUploadBundle:Upload:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Upload entity.
     *
     * @param Upload $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Upload $entity)
    {
        $form = $this->createForm(new UploadType(), $entity, array(
            'action' => $this->generateUrl('upload_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Upload entity.
     *
     */
    public function newAction()
    {
        $entity = new Upload();
        $form   = $this->createCreateForm($entity);

        return $this->render('JCVUploadBundle:Upload:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Upload entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JCVUploadBundle:Upload')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Upload entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JCVUploadBundle:Upload:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Perist xml file data.
     *
     */
    public function persistAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository=$em->getRepository('JCVUploadBundle:Upload');

        $entity = $repository->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Upload entity.');
        }

        // remove already loaded activities  if any
        $activities = $entity->getActivities();
        foreach ($activities as $activity) {
            $em->remove($activity);
        }
        $em->flush();

        // persist activities, laps, tracks and trackpoints
        $entities = $repository->persistXml($entity);

        $this->doPersistAction($entities);

        $entity->setLoaded(true);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'xml data loaded to database.');

        return $this->redirect($this->generateUrl('upload'));
    }

     /**
     * Displays a form to edit an existing Upload entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JCVUploadBundle:Upload')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Upload entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JCVUploadBundle:Upload:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Upload entity.
    *
    * @param Upload $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Upload $entity)
    {
        $form = $this->createForm(new UploadEditType($entity), $entity, array(
            'action' => $this->generateUrl('upload_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Upload entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JCVUploadBundle:Upload')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Upload entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('upload_edit', array('id' => $id)));
        }

        return $this->render('JCVUploadBundle:Upload:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Upload entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux administrateurs.');
        }
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JCVUploadBundle:Upload')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Upload entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('upload'));
    }

    /**
     * Creates a form to delete a Upload entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('upload_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function doPersistAction($entities) {
        $em = $this->getDoctrine()->getManager();
        $activities = $entities[0];
        foreach ($activities as $activity) {
            $em->persist($activity);
        }
        $em->flush();

        $laps = $entities[1];
        foreach ($laps as $lap) {
            $em->persist($lap);
        }
        $em->flush();

        $tracks = $entities[2];
        foreach ($tracks as $track) {
            $em->persist($track);
        }
        $em->flush();

        $trackPoints = $entities[3];
        foreach ($trackPoints as $trackPoint) {
            $em->persist($trackPoint);
        }
        $em->flush();
    }
}
