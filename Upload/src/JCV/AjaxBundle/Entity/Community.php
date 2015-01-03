<?php

namespace JCV\AjaxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Community
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JCV\AjaxBundle\Entity\CommunityRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Community
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

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
     * @ORM\OneToMany(targetEntity="JCV\AjaxBundle\Entity\Province", mappedBy="community")
     */
    private $provinces;

    /**
     * @ORM\OneToMany(targetEntity="JCV\AjaxBundle\Entity\Location", mappedBy="community")
     */
    private $locations;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->provinces = new ArrayCollection();
        $this->locations = new ArrayCollection();
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
     * @return Community
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
     * @return Community
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
     * Set name
     *
     * @param string $name
     * @return Community
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add provinces
     *
     * @param \JCV\AjaxBundle\Entity\Province $provinces
     * @return Community
     */
    public function addProvince(\JCV\AjaxBundle\Entity\Province $provinces)
    {
        $this->provinces[] = $provinces;

        return $this;
    }

    /**
     * Remove provinces
     *
     * @param \JCV\AjaxBundle\Entity\Province $provinces
     */
    public function removeProvince(\JCV\AjaxBundle\Entity\Province $provinces)
    {
        $this->provinces->removeElement($provinces);
    }

    /**
     * Get provinces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProvinces()
    {
        return $this->provinces;
    }

    /**
     * Add locations
     *
     * @param \JCV\AjaxBundle\Entity\Location $locations
     * @return Community
     */
    public function addLocation(\JCV\AjaxBundle\Entity\Location $locations)
    {
        $this->locations[] = $locations;

        return $this;
    }

    /**
     * Remove locations
     *
     * @param \JCV\AjaxBundle\Entity\Location $locations
     */
    public function removeLocation(\JCV\AjaxBundle\Entity\Location $locations)
    {
        $this->locations->removeElement($locations);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocations()
    {
        return $this->locations;
    }
}
