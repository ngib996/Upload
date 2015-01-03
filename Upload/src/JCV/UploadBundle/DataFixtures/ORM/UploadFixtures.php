<?php

// src/JCV/uploadBundle/DataFixtures/ORM/uploadFixtures.php

namespace Ens\uploadeetBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JCV\UploadBundle\Entity\Upload;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class uploadFixtures extends AbstractFixture implements OrderedFixtureInterface,  ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $em) {

        $fileNames=array('1h cool' =>'activity_547751534.tcx',
            'reveil musculaire' => 'activity_556737528.tcx',
            '4*1000m' => 'activity_569541147.tcx',
            'Activité A' => 'activity_573551151.tcx',
            'Activité B' =>'activity_573551152.tcx',
            'Activité C' => 'activity_test.tcx',
            'Activité D' =>'activity_475387013.tcx');

        foreach ($fileNames as $key => $fileName) {
            $upload = new upload();
            copy($upload->getFixturesPath() . $fileName, $upload->getFixturesPath() . $fileName .'.copy');
            $file = new UploadedFile($upload->getFixturesPath() . $fileName .'.copy', $fileName, null, null, null, true);
            $upload->setUploadFile($file);
            $upload->setOriginalFile($file);
            $upload->setFile($file);
            $upload->setLoaded(false);
            $upload->setName($key);
            $em->persist($upload);
        }

        $em->flush();

//        $this->addReference('category-design', $design);
//        $this->addReference('category-programming', $programming);
//        $this->addReference('category-manager', $manager);
//        $this->addReference('category-administrator', $administrator);

    }

     public function getOrder() {
        return 1;
    }

}
