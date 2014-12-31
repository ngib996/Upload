<?php

// src/JCV/UserBundle/DataFixtures/ORM/UserFixtures.php

namespace JCV\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JCV\UserBundle\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface,  ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $userManager = $this->container->get('fos_user.user_manager');

        $user1 = $userManager->createUser();

        $user1->setUsername('jcv');
        $user1->setEmail('jeanchristophe.verhulst@gmail.com');
        $user1->setPhone('+32479175304');
        $user1->setPlainPassword('jcv');
        $user1->setEnabled(true);
        $user1->setFirstName('Jean-Christophe');
        $user1->setLastName('Verhulst');
        $user1->setGender('male');
        $user1->setNamePrefix('Mr.');
        $user1->setRoles(array('ROLE_USER'));
        $user1->setImage($manager->merge($this->getReference('image-9')));
        $userManager->updateUser($user1, true);
        $manager->persist($user1);

        $user2 = $userManager->createUser();

        $user2->setUsername('arnaud');
        $user2->setEmail('arnaud.verhulst@gmail.com');
        $user2->setPhone('+32497932768');
        $user2->setPlainPassword('arnaud');
        $user2->setEnabled(true);
        $user2->setFirstName('Arnaud');
        $user2->setLastName('Verhulst');
        $user2->setGender('male');
        $user2->setNamePrefix('Mr.');
        $user2->setRoles(array('ROLE_ADMIN'));
        $user2->setImage($manager->merge($this->getReference('image-6')));
        $userManager->updateUser($user2, true);
        $manager->persist($user2);

        $user3 = $userManager->createUser();

        $user3->setUsername('vic');
        $user3->setEmail('vitoria.verhulst@gmail.com');
        $user3->setPhone('+32493599603');
        $user3->setPlainPassword('vic');
        $user3->setEnabled(true);
        $user3->setFirstName('Victoria');
        $user3->setLastName('Verhulst');
        $user3->setGender('female');
        $user3->setNamePrefix('Mrs.');
        $user3->setRoles(array('ROLE_ADMIN'));
        $user3->setImage($manager->merge($this->getReference('image-7')));
        $userManager->updateUser($user3, true);
        $manager->persist($user3);

        $user4 = $userManager->createUser();

        $user4->setUsername('isa');
        $user4->setEmail('isa.gioia272@gmail.com');
        $user4->setPhone('+32494829181');
        $user4->setPlainPassword('isa');
        $user4->setEnabled(true);
        $user4->setFirstName('Isabelle');
        $user4->setLastName('Goffinet');
        $user4->setGender('female');
        $user4->setNamePrefix('Mrs.');
        $user4->setRoles(array('ROLE_USER', 'ROLE_ADMIN'));
        $user4->setImage($manager->merge($this->getReference('image-8')));
        $userManager->updateUser($user4, true);
        $manager->persist($user4);

        $em = $this->container->get('doctrine')->getManager();
        $repositoryUser = $em->getRepository('JCVUserBundle:User');

        $jcv=$repositoryUser->findOneBy(array('firstName' => 'Jean-Christophe','lastName'=>'Verhulst'));
        $isa = $repositoryUser->findOneBy(array('firstName' => 'Isabelle', 'lastName' => 'Goffinet'));
        $jcv->setLifePartner($isa);
        $isa->setLifePartner($jcv);

        $manager->flush();
    }

     public function getOrder() {
        return 2;
    }

}
