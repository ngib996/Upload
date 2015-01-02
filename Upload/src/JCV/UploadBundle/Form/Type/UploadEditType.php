<?php
// src/JCV/UploadBundle/Form/Type/UploadEditType.php

namespace JCV\UploadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JCV\UploadBundle\Entity\Upload;
use JCV\UploadBundle\Form\UploadType;

class UploadEditType extends AbstractType
{
    protected $upload;

    public function __construct(Upload $upload) {
        $this->upload = $upload;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('file');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jcv_bundle_upload_edit';
    }

    public function getParent() {
        return new UploadType($this->upload);
    }

}
