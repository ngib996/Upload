<?php

namespace JCV\AjaxBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Finder\Finder;
use JCV\AjaxBundle\Entity\Product;
use JCV\AjaxBundle\Entity\Category;
use JCV\AjaxBundle\Entity\Community;
use JCV\AjaxBundle\Entity\Province;

 
class SomeProducts extends AbstractFixture implements OrderedFixtureInterface,  ContainerAwareInterface {

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

        $categories = Array();
        foreach ($loader['categories'] as $key => $category) {
            $categories[$key] = new Category();
            $categories[$key]->setName($category['name']);

            $em->persist($categories[$key]);
        }

        $products= Array();

        foreach ($loader['products'] as $key => $product) {
            $products[$key] = new Product();
            $products[$key]->setName($product['name']);
            $products[$key]->setPrice($product['price']);
            $products[$key]->setDescription($product['description']);
            $products[$key]->setCategory($categories[$product['category']]);

            $em->persist($products[$key]);
        }

        $communities = Array();

        foreach ($loader['communities'] as $key => $community) {
            $communities[$key] = new Community();
            $communities[$key]->setName($community['name']);

            $em->persist($communities[$key]);
        }

        $provinces = Array();

        foreach ($loader['provinces'] as $key => $province) {
            $provinces[$key] = new Province();
            $provinces[$key]->setName($province['name']);
            $provinces[$key]->setCommunity($communities[$province['community']]);

            $em->persist($provinces[$key]);

            $this->addReference($key,$provinces[$key]);

        }

        $em->flush();

    }

    public function getOrder()
    {
        return 1;
    }

}
