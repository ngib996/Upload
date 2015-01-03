<?php

namespace JCV\AjaxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Location
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JCV\AjaxBundle\Entity\LocationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=false)
     */
    private $street;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="JCV\AjaxBundle\Entity\Provider", mappedBy="location")
     */
    private $providers;

    /**
     * @ORM\ManyToOne(targetEntity="JCV\AjaxBundle\Entity\Community", inversedBy="locations")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $community;

    /**
     * @ORM\ManyToOne(targetEntity="JCV\AjaxBundle\Entity\Province", inversedBy="locations")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $province;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->providers = new ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue() {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


     /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Location
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Location
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Location
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Location
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Add providers
     *
     * @param \JCV\AjaxBundle\Entity\Provider $providers
     * @return Location
     */
    public function addProvider(\JCV\AjaxBundle\Entity\Provider $providers)
    {
        $this->providers[] = $providers;

        return $this;
    }

    /**
     * Remove providers
     *
     * @param \JCV\AjaxBundle\Entity\Provider $providers
     */
    public function removeProvider(\JCV\AjaxBundle\Entity\Provider $providers)
    {
        $this->providers->removeElement($providers);
    }

    /**
     * Get providers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Set community
     *
     * @param \JCV\AjaxBundle\Entity\Community $community
     * @return Location
     */
    public function setCommunity(\JCV\AjaxBundle\Entity\Community $community)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \JCV\AjaxBundle\Entity\Community 
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Set province
     *
     * @param \JCV\AjaxBundle\Entity\Province $province
     * @return Location
     */
    public function setProvince(\JCV\AjaxBundle\Entity\Province $province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \JCV\AjaxBundle\Entity\Province 
     */
    public function getProvince()
    {
        return $this->province;
    }
}
