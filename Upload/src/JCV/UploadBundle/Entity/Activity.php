<?php

namespace JCV\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Activity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JCV\UploadBundle\Entity\ActivityRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Activity
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
     * @ORM\Column(name="sport", type="string", length=255, nullable=false)
     */
    private $sport;

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
     * @ORM\ManyToOne(targetEntity="JCV\UploadBundle\Entity\Upload", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $upload;

    /**
     * @ORM\OneToMany(targetEntity="JCV\UploadBundle\Entity\Lap", mappedBy="activity")
     */
    private $laps;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->laps = new ArrayCollection();
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
     * @return Activity
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
     * Set sport
     *
     * @param string $sport
     * @return Activity
     */
    public function setSport($sport)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport
     *
     * @return string 
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Activity
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
     * @return Activity
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
     * Set upload
     *
     * @param \JCV\UploadBundle\Entity\Upload $upload
     * @return Activity
     */
    public function setUpload(\JCV\UploadBundle\Entity\Upload $upload)
    {
        $this->upload = $upload;

        return $this;
    }

    /**
     * Get upload
     *
     * @return \JCV\UploadBundle\Entity\Upload 
     */
    public function getUpload()
    {
        return $this->upload;
    }

    /**
     * Add laps
     *
     * @param \JCV\UploadBundle\Entity\Lap $laps
     * @return Activity
     */
    public function addLap(\JCV\UploadBundle\Entity\Lap $laps)
    {
        $this->laps[] = $laps;

        return $this;
    }

    /**
     * Remove laps
     *
     * @param \JCV\UploadBundle\Entity\Lap $laps
     */
    public function removeLap(\JCV\UploadBundle\Entity\Lap $laps)
    {
        $this->laps->removeElement($laps);
    }

    /**
     * Get laps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLaps()
    {
        return $this->laps;
    }
}
