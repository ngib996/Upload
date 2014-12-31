<?php

namespace JCV\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TrackPoint
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JCV\UploadBundle\Entity\TrackPointRepository")
 * @ORM\HasLifecycleCallbacks
 */
class TrackPoint
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
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="altitude", type="float", nullable=true)
     */
    private $altitude;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="float", nullable=true)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="hr", type="integer", nullable=true)
     */
    private $hr;

    /**
     * @var string
     *
     * @ORM\Column(name="speed", type="float", nullable=true)
     */
    private $speed;

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
     * @ORM\ManyToOne(targetEntity="JCV\UploadBundle\Entity\Track", inversedBy="trackpoints")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $track;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
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
     * @return TrackPoint
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
     * @return TrackPoint
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
     * Set startTime
     *
     * @param string $startTime
     * @return TrackPoint
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
     * Set latitude
     *
     * @param float $latitude
     * @return TrackPoint
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return TrackPoint
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set altitude
     *
     * @param float $altitude
     * @return TrackPoint
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;

        return $this;
    }

    /**
     * Get altitude
     *
     * @return float 
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * Set distance
     *
     * @param float $distance
     * @return TrackPoint
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return float 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set hr
     *
     * @param integer $hr
     * @return TrackPoint
     */
    public function setHr($hr)
    {
        $this->hr = $hr;

        return $this;
    }

    /**
     * Get hr
     *
     * @return integer 
     */
    public function getHr()
    {
        return $this->hr;
    }

    /**
     * Set speed
     *
     * @param float $speed
     * @return TrackPoint
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return float 
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set track
     *
     * @param \JCV\UploadBundle\Entity\Track $track
     * @return TrackPoint
     */
    public function setTrack(\JCV\UploadBundle\Entity\Track $track)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * Get track
     *
     * @return \JCV\UploadBundle\Entity\Track 
     */
    public function getTrack()
    {
        return $this->track;
    }
}
