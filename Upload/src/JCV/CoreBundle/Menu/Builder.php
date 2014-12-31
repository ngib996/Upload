<?php

// src/JCV/CoreBundle/Menu/Builder.php

namespace JCV\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

    public function HomeMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-left');

        $menu->addChild('Home')->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');

        $menu['Home']->addChild('Home', array('route' => 'jcv_core_homepage'))->setAttribute('icon', 'fa fa-home fa-fw');
        $menu['Home']->addChild('Contact', array('route' => 'jcv_core_contact'))->setAttribute('icon', 'fa fa-user fa-fw');

        return $menu;
    }

    public function AdminMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-left');

        $menu->addChild('Admin')->setAttribute('dropdown', true);

        $menu['Admin']->addChild('Users')->setAttribute('icon', 'fa fa-user fa-fw');
        $menu['Admin']->addChild('UserList', array('route' => 'jcv_user_home'))->setAttribute('icon', 'fa fa-newspaper-o fa-fw');
        $menu['Admin']->addChild('UserAdd', array('route' => 'fos_user_registration_register'))->setAttribute('icon', 'fa fa-user fa-fw')->setAttribute('divider_append', true);

        $menu['Admin']->addChild('Category')->setAttribute('icon', 'fa fa-user fa-fw');
        $menu['Admin']->addChild('CategoryList', array('route' => 'jcv_user_home'))->setAttribute('icon', 'fa fa-newspaper-o fa-fw');
        $menu['Admin']->addChild('CategoryAdd', array('route' => 'jcv_user_add'))->setAttribute('icon', 'fa fa-user fa-fw')->setAttribute('divider_append', true);
        return $menu;
    }

      public function UploadMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-left');

        $menu->addChild('Upload')->setAttribute('dropdown', true);



        $menu['Upload']->addChild('List', array('route' => 'upload'))->setAttribute('icon', 'fa fa-newspaper-o fa-fw');
        $menu['Upload']->addChild('Add', array('route' => 'upload_new'))->setAttribute('icon', 'fa fa-user fa-fw');

        return $menu;
    }



    public function LogoutMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-left');

        $menu->addChild('Logout', array('route' => 'fos_user_security_logout'))->setAttribute('icon', 'fa fa-sign-out fa-fw');

        return $menu;
    }

}
