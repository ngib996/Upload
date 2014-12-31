<?php

namespace JCV\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lap
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JCV\UploadBundle\Entity\LapRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Lap
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
     * @ORM\Column(name="start_time", type="datetime", nullable=false)
     */
    private $startTime;

    /**
     * @var string
     *
     * @ORM\Column(name="spent_time", type="float", nullable=false)
     */
    private $spentTime;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="float", nullable=false)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="max_speed", type="float", nullable=false)
     */
    private $maxSpeed;

    /**
     * @var string
     *
     * @ORM\Column(name="avg_hr", type="integer", nullable=true)
     */
    private $avgHr;

    /**
     * @var string
     *
     * @ORM\Column(name="max_hr", type="integer", nullable=true)
     */
    private $maxHr;

    /**
     * @var string
     *
     * @ORM\Column(name="calorie", type="integer", nullable=false)
     */
    private $calorie;

    /**
     * @var string
     *
     * @ORM\Column(name="intensity", type="string", length=255, nullable=false)
     */
    private $intensity;

    /**
     * @var string
     *
     * @ORM\Column(name="avg_speed", type="float", nullable=true)
     */
    private $avgSpeed;

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
     * @ORM\ManyToOne(targetEntity="JCV\UploadBundle\Entity\Activity", inversedBy="laps")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $activity;

    /**
     * @ORM\OneToMany(targetEntity="JCV\UploadBundle\Entity\Track", mappedBy="lap")
     */
    private $tracks;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->tracks = new ArrayCollection();
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
     * Set startTime
     *
     * @param string $startTime
     * @return Lap
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return string 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set spentTime
     *
     * @param string $spentTime
     * @return Lap
     */
    public function setSpentTime($spentTime)
    {
        $this->spentTime = $spentTime;

        return $this;
    }

    /**
     * Get spentTime
     *
     * @return string 
     */
    public function getSpentTime()
    {
        return $this->spentTime;
    }

    /**
     * Set distance
     *
     * @param string $distance
     * @return Lap
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return string 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set maxSpeed
     *
     * @param string $maxSpeed
     * @return Lap
     */
    public function setMaxSpeed($maxSpeed)
    {
        $this->maxSpeed = $maxSpeed;

        return $this;
    }

    /**
     * Get maxSpeed
     *
     * @return string 
     */
    public function getMaxSpeed()
    {
        return $this->maxSpeed;
    }

    /**
     * Set avgHr
     *
     * @param string $avgHr
     * @return Lap
     */
    public function setAvgHr($avgHr)
    {
        $this->avgHr = $avgHr;

        return $this;
    }

    /**
     * Get avgHr
     *
     * @return string 
     */
    public function getAvgHr()
    {
        return $this->avgHr;
    }

    /**
     * Set maxHr
     *
     * @param string $maxHr
     * @return Lap
     */
    public function setMaxHr($maxHr)
    {
        $this->maxHr = $maxHr;

        return $this;
    }

    /**
     * Get maxHr
     *
     * @return string 
     */
    public function getMaxHr()
    {
        return $this->maxHr;
    }

    /**
     * Set calorie
     *
     * @param string $calorie
     * @return Lap
     */
    public function setCalorie($calorie)
    {
        $this->calorie = $calorie;

        return $this;
    }

    /**
     * Get calorie
     *
     * @return string 
     */
    public function getCalorie()
    {
        return $this->calorie;
    }

    /**
     * Set intensity
     *
     * @param string $intensity
     * @return Lap
     */
    public function setIntensity($intensity)
    {
        $this->intensity = $intensity;

        return $this;
    }

    /**
     * Get intensity
     *
     * @return string 
     */
    public function getIntensity()
    {
        return $this->intensity;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Lap
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
     * @return Lap
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
     * Set activity
     *
     * @param \JCV\UploadBundle\Entity\Activity $activity
     * @return Lap
     */
    public function setActivity(\JCV\UploadBundle\Entity\Activity $activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \JCV\UploadBundle\Entity\Activity 
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set avgSpeed
     *
     * @param string $avgSpeed
     * @return Lap
     */
    public function setAvgSpeed($avgSpeed)
    {
        $this->avgSpeed = $avgSpeed;

        return $this;
    }

    /**
     * Get avgSpeed
     *
     * @return string 
     */
    public function getAvgSpeed()
    {
        return $this->avgSpeed;
    }

    /**
     * Add tracks
     *
     * @param \JCV\UploadBundle\Entity\Track $tracks
     * @return Lap
     */
    public function addTrack(\JCV\UploadBundle\Entity\Track $tracks)
    {
        $this->tracks[] = $tracks;

        return $this;
    }

    /**
     * Remove tracks
     *
     * @param \JCV\UploadBundle\Entity\Track $tracks
     */
    public function removeTrack(\JCV\UploadBundle\Entity\Track $tracks)
    {
        $this->tracks->removeElement($tracks);
    }

    /**
     * Get tracks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTracks()
    {
        return $this->tracks;
    }
}
