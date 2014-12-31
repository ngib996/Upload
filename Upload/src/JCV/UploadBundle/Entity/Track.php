<?php

namespace JCV\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Track
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JCV\UploadBundle\Entity\TrackRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Track
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
     * @ORM\ManyToOne(targetEntity="JCV\UploadBundle\Entity\Lap", inversedBy="tracks")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $lap;

    /**
     * @ORM\OneToMany(targetEntity="JCV\UploadBundle\Entity\TrackPoint", mappedBy="track")
     */
    private $trackpoints;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->trackpoints = new ArrayCollection();
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
     * @return Track
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
     * @return Track
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
     * Set lap
     *
     * @param \JCV\UploadBundle\Entity\Lap $lap
     * @return Track
     */
    public function setLap(\JCV\UploadBundle\Entity\Lap $lap)
    {
        $this->lap = $lap;

        return $this;
    }

    /**
     * Get lap
     *
     * @return \JCV\UploadBundle\Entity\Lap 
     */
    public function getLap()
    {
        return $this->lap;
    }

    /**
     * Add trackpoints
     *
     * @param \JCV\UploadBundle\Entity\TrackPoint $trackpoints
     * @return Track
     */
    public function addTrackpoint(\JCV\UploadBundle\Entity\TrackPoint $trackpoints)
    {
        $this->trackpoints[] = $trackpoints;

        return $this;
    }

    /**
     * Remove trackpoints
     *
     * @param \JCV\UploadBundle\Entity\TrackPoint $trackpoints
     */
    public function removeTrackpoint(\JCV\UploadBundle\Entity\TrackPoint $trackpoints)
    {
        $this->trackpoints->removeElement($trackpoints);
    }

    /**
     * Get trackpoints
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrackpoints()
    {
        return $this->trackpoints;
    }
}
