<?php

namespace JCV\AjaxBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Finder\Finder;
use JCV\AjaxBundle\Entity\Provider;
use JCV\AjaxBundle\Entity\Location;

 
class SomeProviders extends AbstractFixture implements OrderedFixtureInterface,  ContainerAwareInterface{

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $em)
    {
        /* load data from yaml file */

        $finder = new Finder();
        $finder->files()->name('data.yml')->in(__DIR__);

        foreach ($finder as $file) {
            $loader = Yaml::parse($file->getRealpath());
        }

        $locations = Array();

        foreach ($loader['locations'] as $key => $location) {
            $locations[$key] = new Location();
            $locations[$key]->setStreet($location['street']);
            $locations[$key]->setCity($location['city']);
            $locations[$key]->setProvince(
                $em->merge($this->getReference($location['province'])));
            $community = $locations[$key]->getProvince()->getCommunity();
            $locations[$key]->SetCommunity($community);

            $em->persist($locations[$key]);
        }

        $providers = Array();
        foreach ($loader['providers'] as $key => $provider) {
            $providers[$key] = new Provider();
            $providers[$key]->setName($provider['name']);
            $providers[$key]->setPhone($provider['phone']);
            $providers[$key]->setLocation($locations[$provider['location']]);

            $em->persist($providers[$key]);
        }

        $em->flush();

    }

    public function getOrder()
    {
        return 2;
    }

}
