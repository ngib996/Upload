<?php

// src/JCV/CoreBundle/Menu/Builder.php

namespace JCV\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

    public function Home1Menu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-left');

        //$menu->addChild('Home', array('route' => 'jcv_core_homepage'))->setAttribute('icon', 'icon-list');

        $menu->addChild('Home')->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');



        $menu['Home']->addChild('Home', array('route' => 'jcv_core_homepage'))->setAttribute('icon', 'icon-edit');
        $menu['Home']->addChild('Contact', array('route' => 'jcv_core_contact'))->setAttribute('icon', 'icon-edit');

//        $menu->addChild('About Me', array(
//            'route' => 'page_show',
//            'routeParameters' => array('id' => 42)
//        ));
        // ... add more children

        return $menu;
    }

    public function AdminMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-left');


        $menu->addChild('Admin')->setAttribute('dropdown', true)->setAttribute('icon', 'icon-user');
        $menu['Admin']->addChild('Users');


        $menu['Admin']->addChild('UserList', array('route' => 'jcv_user_home'))->setAttribute('icon', 'icon-edit');
        $menu['Admin']->addChild('UserAdd', array('route' => 'jcv_user_add'))->setAttribute('icon', 'icon-edit');

//        $menu->addChild('About Me', array(
//            'route' => 'page_show',
//            'routeParameters' => array('id' => 42)
//        ));
        // ... add more children

        return $menu;
    }

}
