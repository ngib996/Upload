<?php
// src/JCV/UploadBundle/Form/Type/UploadSelectByIdType.php

namespace JCV\UploadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use JCV\UploadBundle\Entity\Upload;

class UploadSelectByIdType extends AbstractType
{
//    protected $upload;
//
//    public function __construct(Upload $upload) {
//        $this->upload = $upload;
//    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ids', 'entity', array(
                'required'      => false,
                'class'         => 'JCVUploadBundle:Upload',
                'property'      => 'id',
//                'property_path' => '[id]', # in square brackets!
                'multiple'      => true,
//                'label' => '',
                'expanded'      => true
            ))
//            ->add('loaded','entity',array(
//                'class' => 'JCVUploadBundle:Upload',
//                'property' => "loaded",
//                'expanded' => true,
//                'multiple' => true,
//                'disabled' => true,
//
//            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JCV\UploadBundle\Entity\Upload',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jcv_bundle_upload';
    }
}
