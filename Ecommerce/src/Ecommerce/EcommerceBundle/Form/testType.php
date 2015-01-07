<?php

namespace Ecommerce\EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class testType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email','email',array('required' => false))
            ->add('nom',null,array('required' => false))
            ->add('prenom')
            ->add('sexe','choice',array('choices' => array('0' => 'homme',
                '1' => 'femme',
                '2' => 'autre'),'preferred_choices' => array('1','2'),'expanded' => true))
            ->add('contenu','textarea')
            ->add('date','datetime')
            ->add('utilisateurs','entity', array('class' => 'Users\UsersBundle\Entity\Users'))
            ->add('pays','country')
            ->add('envoyer','submit');
    }

    public function getName()
    {
        return 'ecommerce_ecommercebundle_test';
    }
}