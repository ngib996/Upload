<?php
// src/JCV/UserBundle/Form/Type/UserType.php

namespace JCV\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use JCV\UserBundle\Entity\User;

class UserType extends AbstractType
{
    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           // ->add('created', 'datePicker', array())
            ->add('firstName', 'text')
            ->add('userName', 'text')
            ->add('phone', 'text')
             ->add('lastName', 'text')
            ->add('namePrefix', 'choice', array(
                    'choices' => array('Mr.' => 'Monsieur', 'Mrs.' => 'Madame'),
                    'required' => true,
                ))
            ->add('gender', 'choice', array(
                    'choices' => array('male' => 'Masculin', 'female' => 'Féminin'),
                    'required' => true,
                ))
            ->add('email', 'email')
                ->add('lifePartner', 'entity', array(
                    'class' => 'JCVUserBundle:User',
                    'property' => 'firstName',
                    'multiple' => false,
                    'required' => false
            ))
            ->add('myFriends', 'entity', array(
                'class' => 'JCVUserBundle:User',
                'property' => 'firstName',
                'multiple' => true
            ))
//            ->add('userInfo', new UserInfoType())
            //->add('published', 'checkbox', array('required' => false))
            ->add('image', new ImageType(), array(
                   'required' => false
                ))
            ->add('roles', 'entity', array(
                    'class' => 'JCVUserBundle:Role',
                    'property' => 'label',
                    'multiple' => true,
                ))
//                ->add('roles', 'collection', array(
//                    'type' => 'text'
//                ))
                ->add('save', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JCV\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jcv_bundle_user';
    }
}
