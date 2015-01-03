<?php

namespace JCV\UploadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UploadActivityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sport')
            ->add('startTime', 'dateTimePicker', array())
            ->add('submit', 'submit', array('label' => 'Update'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JCV\UploadBundle\Entity\Activity',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jcv_uploadbundle_activity';
    }
}
