<?php
namespace Users\UsersBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Users\UsersBundle\Entity\Users;

class UsersData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function load(ObjectManager $manager)
    {
        $user1 = new Users();
        $user1->setUsername('jcv');
        $user1->setEmail('jcv@gmail.com');
        $user1->setEnabled(1);
        $user1->setPassword($this->container->get('security.encoder_factory')->getEncoder($user1)->encodePassword('mimile', $user1->getSalt()));
        $manager->persist($user1);

        $user2 = new Users();
        $user2->setUsername('mathilde');
        $user2->setEmail('mathilde@gmail.com');
        $user2->setEnabled(1);
        $user2->setPassword($this->container->get('security.encoder_factory')->getEncoder($user2)->encodePassword('mathilde', $user2->getSalt()));
        $manager->persist($user2);

        $user3 = new Users();
        $user3->setUsername('pauline');
        $user3->setEmail('pauline@gmail.com');
        $user3->setEnabled(1);
        $user3->setPassword($this->container->get('security.encoder_factory')->getEncoder($user3)->encodePassword('pauline', $user3->getSalt()));
        $manager->persist($user3);

        $user4 = new Users();
        $user4->setUsername('tiffany');
        $user4->setEmail('tiffany@gmail.com');
        $user4->setEnabled(1);
        $user4->setPassword($this->container->get('security.encoder_factory')->getEncoder($user4)->encodePassword('tiffany', $user4->getSalt()));
        $manager->persist($user4);

        $user5 = new Users();
        $user5->setUsername('dominique');
        $user5->setEmail('dominique@gmail.com');
        $user5->setEnabled(1);
        $user5->setPassword($this->container->get('security.encoder_factory')->getEncoder($user5)->encodePassword('dominique', $user5->getSalt()));
        $manager->persist($user5);

        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
        $this->addReference('user3', $user3);
        $this->addReference('user4', $user4);
        $this->addReference('user5', $user5);
    }

    public function getOrder()
    {
        return 5;
    }
}