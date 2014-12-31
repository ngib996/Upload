<?php

// src/JCV/UserBundle/DataFixtures/ORM/RoleFixtures.php

namespace JCV\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JCV\UserBundle\Entity\Role;

class RoleFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        // Liste des noms de catégorie à ajouter
        $role1 = new Role();
        $role1->setLabel('ROLE_USER');
        $role1->setCreated(new \DateTime());
        $role1->setUpdated($role1->getCreated());
        $manager->persist($role1);

        $role2 = new Role();
        $role2->setLabel('ROLE_ADMIN');
        $role2->setCreated(new \DateTime());
        $role2->setUpdated($role2->getCreated());
        $manager->persist($role2);

        $manager->flush();

        $this->addReference('role-1', $role1);
        $this->addReference('role-2', $role2);
    }

     public function getOrder() {
        return 1;
    }

}
