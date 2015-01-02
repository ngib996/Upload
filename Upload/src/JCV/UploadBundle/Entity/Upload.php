<?php

namespace JCV\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Upload
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JCV\UploadBundle\Entity\UploadRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Upload
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
     * @var string
     *
     * @ORM\Column(name="upload_file", type="string", length=255, nullable=false)
     */
    private $uploadFile;

    /**
     * @var string
     *
     * @ORM\Column(name="original_file", type="string", length=255, nullable=false,unique=true)
     */
    private $originalFile;

    /**
     * @var boolean
     *
     * @ORM\Column(name="loaded", type="boolean", nullable=true)
     */
    private $loaded;

    public $file;

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
     * @ORM\OneToMany(targetEntity="JCV\UploadBundle\Entity\Activity", mappedBy="upload")
     */
    private $activities;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->activities = new ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue() {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->uploadFile = uniqid().'.'.$this->file->guessExtension();
            $this->originalFile = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->uploadFile);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
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
     * Set uploadFile
     *
     * @param string $uploadFile
     * @return Upload
     */
    public function setUploadFile($uploadFile)
    {
        $this->uploadFile = $uploadFile;

        return $this;
    }

    /**
     * Get uploadFile
     *
     * @return string 
     */
    public function getUploadFile()
    {
        return $this->uploadFile;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Upload
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
     * @return Upload
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

    public function getUploadDir()
    {
        return 'uploads/xml';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->uploadFile ? null : $this->getUploadDir().'/'.$this->uploadFile;
    }

    public function getAbsolutePath()
    {
        return null === $this->uploadFile ? null : $this->getUploadRootDir() . '/' . $this->uploadFile;
    }

    /**
     * Set originalFile
     *
     * @param string $originalFile
     * @return Upload
     */
    public function setOriginalFile($originalFile)
    {
        $this->originalFile = $originalFile;

        return $this;
    }

    /**
     * Get originalFile
     *
     * @return string 
     */
    public function getOriginalFile()
    {
        return $this->originalFile;
    }

    public function getFixturesPath()
    {
        return $this->getAbsolutePath() . 'web/uploads/fixtures/';
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
//        // check if we have an old image path
//        if (isset($this->path)) {
//            // store the old name to delete after the update
//            $this->temp = $this->path;
//            $this->path = null;
//        } else {
//            $this->path = 'initial';
//        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Add activities
     *
     * @param \JCV\UploadBundle\Entity\Activity $activities
     * @return Upload
     */
    public function addActivity(\JCV\UploadBundle\Entity\Activity $activities)
    {
        $this->activities[] = $activities;

        return $this;
    }

    /**
     * Remove activities
     *
     * @param \JCV\UploadBundle\Entity\Activity $activities
     */
    public function removeActivity(\JCV\UploadBundle\Entity\Activity $activities)
    {
        $this->activities->removeElement($activities);
    }

    /**
     * Get activities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * Set loaded
     *
     * @param boolean $loaded
     * @return Upload
     */
    public function setLoaded($loaded)
    {
        $this->loaded = $loaded;

        return $this;
    }

    /**
     * Get loaded
     *
     * @return boolean 
     */
    public function getLoaded()
    {
        return $this->loaded;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Upload
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
}
