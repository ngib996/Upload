<?php

namespace JCV\UploadBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JCV\UploadBundle\Entity\Upload;
use JCV\UploadBundle\Form\UploadType;
use JCV\UploadBundle\Form\Type\UploadEditType;
use JCV\UploadBundle\Form\Type\UploadActivityType;
use JCV\UploadBundle\Form\Type\UploadSelectByIdType;
use SaadTazi\GChartBundle\DataTable;

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
        $nbPages = ceil(count($entities) / $nbPerPage);

        $dql   = "SELECT u FROM JCVUploadBundle:Upload u";
        $query = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');

        $entities = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', $page)/*page number*/,
            $nbPerPage
        );


        $form = $this->createForm(new UploadSelectByIdType())->createView();


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
        $activities = $entity->getActivities();
        $laps = array();
        foreach ($activities as $activity) {
            $laps[] = $activity->getLaps();
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Upload entity.');
        }

        $dataTables = $this->buildDataTables($entity);


        $deleteForm = $this->createDeleteForm($id);
        return $this->render('JCVUploadBundle:Upload:show.html.twig', array(
            'entity'      => $entity,
            'activities'  => $activities,
            'laps' => $laps,
            'delete_form' => $deleteForm->createView(),
            'dataTable' => $dataTables[0]->toArray(),
            'dataTable2' => $dataTables[1]->toArray(),
        ));
    }

    /**
     * Finds and displays a Hr detailed activity.
     *
     */
    public function showHrDetailsAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JCVUploadBundle:Upload')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Upload entity.');
        }

        $hrDetails = $em->getRepository('JCVUploadBundle:Upload')->getHrDetails($entity);

        $dataTable = new DataTable\DataTable();
        $dataTable->addColumn('id1', 'time', 'number');
        $dataTable->addColumnObject(new DataTable\DataColumn('id2', 'HR', 'number'));

        foreach ($hrDetails as $key => $value) {
            $dataTable->addRow(array($key, $value[0]));
        }

        return $this->render('JCVUploadBundle:Upload:showHrDetails.html.twig', array(
            'entity'      => $entity,
            'dataTable' => $dataTable->toArray(),
        ));
    }

    /**
     * Perist xml file data.
     *
     */
    public function persistAction($id,Request $request)
    {
        $from=$request->query->get('from');
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

        if ($from == 'show') {
            return $this->redirect($this->generateUrl('upload_show', array('id' => $id)));
        } else {
            return $this->redirect($this->generateUrl('upload'));
        }

    }

    /**
     * Displays a form to edit an existing Activity entity.
     *
     */
    public function editActivityAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $activity = $em->getRepository('JCVUploadBundle:Activity')->find($id);

        if (!$activity) {
            throw $this->createNotFoundException('Unable to find Activity entity.');
        }

        $activity_form = $this->createForm(new uploadActivityType($activity), $activity);

        $activity_form->handleRequest($request);

        if ($activity_form->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Successfully updated activity.');

            // Puis on redirige vers la page de visualisation de cettte annonce
            return $this->redirect($this->generateUrl('upload_show', array('id' => $activity->getUpload()->getId())));
        }

        return $this->render('JCVUploadBundle:Upload:editActivity.html.twig', array('activity' => $activity, 'activity_form' => $activity_form->createView()));
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

//        var_dump($editForm);exit;


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

    private function buildDataTables($entity) {
        $em = $this->getDoctrine()->getManager();
//      HR
        $hrs = $em->getRepository('JCVUploadBundle:Upload')->getHr($entity);
        $dataTable = new DataTable\DataTable();
        $dataTable->addColumn('id1', 'label 1', 'number');
        $dataTable->addColumnObject(new DataTable\DataColumn('id2', 'Avg HR', 'number'));
        $dataTable->addColumnObject(new DataTable\DataColumn('id3', 'Max HR', 'number'));
        foreach ($hrs as $key => $value) {
            $dataTable->addRow(array($key, $value[0], $value[1]));
        }

//        Speed
        $speeds = $em->getRepository('JCVUploadBundle:Upload')->getSpeed($entity);
        $dataTable2 = new DataTable\DataTable();
        $dataTable2->addColumn('id1', 'label 1', 'number');
        $dataTable2->addColumnObject(new DataTable\DataColumn('id2', 'Avg Speed', 'number'));
        $dataTable2->addColumnObject(new DataTable\DataColumn('id3', 'Max Speed', 'number'));
        foreach ($speeds as $key => $value) {
            $dataTable2->addRow(array($key, $value[0], $value[1]));
        }

        return array($dataTable,$dataTable2);
    }
}
