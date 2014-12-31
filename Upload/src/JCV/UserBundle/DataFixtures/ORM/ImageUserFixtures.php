<?php

// src/JCV/UserBundle/DataFixtures/ORM/ImageUserFixtures.php

namespace JCV\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JCV\UserBundle\Entity\Image;

class ImageUserFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        // Liste des noms de catégorie à ajouter
        $image6 = new Image();
        $image6->setUrl('/uploads/img/arnaud.jpg');
        $image6->setAlt('Arnaud');
        $image6->setCreated(new \DateTime());
        $image6->setUpdated($image6->getCreated());
        $manager->persist($image6);

        $image7 = new Image();
        $image7->setUrl('/uploads/img/victoria.jpg');
        $image7->setAlt('Victoria');
        $image7->setCreated(new \DateTime());
        $image7->setUpdated($image7->getCreated());
        $manager->persist($image7);

        $image8 = new Image();
        $image8->setUrl('/uploads/img/isa.jpg');
        $image8->setAlt('Isa');
        $image8->setCreated(new \DateTime());
        $image8->setUpdated($image8->getCreated());
        $manager->persist($image8);

        $image9 = new Image();
        $image9->setUrl('/uploads/img/jc.jpg');
        $image9->setAlt('JC');
        $image9->setCreated(new \DateTime());
        $image9->setUpdated($image9->getCreated());
        $manager->persist($image9);

        $manager->flush();
        $this->addReference('image-6', $image6);
        $this->addReference('image-7', $image7);
        $this->addReference('image-8', $image8);
        $this->addReference('image-9', $image9);
    }

     public function getOrder() {
        return 1;
    }

}
