<?php
// src/JCV/UserBundle/Form/Type/UserEditType.php

namespace JCV\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JCV\UserBundle\Entity\CategoryRepository;
use JCV\UserBundle\Entity\User;

class UserEditType extends AbstractType
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
        $builder->remove('userInfo');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jcv_bundle_user_edit';
    }

    public function getParent() {
        return new UserType($this->user);
    }

}
