<?php
// src/JCV/UserBundle/Entity/User.php

namespace JCV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="user_unique",
 *                                                  columns={"first_name","last_name"})},
 *              indexes={@ORM\Index(name="search_idx",
 *                               columns={"first_name","last_name"})}
 * )
 * @ORM\Entity(repositoryClass="JCV\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", name="first_name", nullable=false) */
    private $firstName;

    /** @ORM\Column(type="string", name="last_name", nullable=false) */
    private $lastName;

    /** @ORM\Column(type="string", nullable=false) */
    private $gender;

    /** @ORM\Column(type="string", name="name_prefix", nullable=false) */
    private $namePrefix;

     /** @ORM\Column(type="string", nullable=true)
     * @Assert\Length(min=6)
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;

    const GENDER_MALE_DISPLAY_VALUE = "Mr.";
    const GENDER_FEMALE_DISPLAY_VALUE = "Mrs.";

    /**
     * @ORM\OneToOne(targetEntity="JCV\UserBundle\Entity\Image", cascade={"persist","remove"})
     */
    private $image;


    /**
     * @ORM\OneToOne(targetEntity="JCV\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="live_partner_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $lifePartner;

    /**
    * @ORM\ManyToMany(targetEntity="JCV\UserBundle\Entity\User")
    * @ORM\JoinTable(name="friends",
    *       joinColumns={@ORM\JoinColumn(name="user_id",
    *                       referencedColumnName="id")},
    *       inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id",referencedColumnName="id")}
    * )
    **/
    private $myFriends;


    public function __construct()
    {
      parent::__construct();
      $this->setCreated(new \DateTime());
      $this->setUpdated(new \DateTime());
      $this->myFriends = new ArrayCollection();
    }

    /**
    * @ORM\PreUpdate
    */
    public function setUpdatedValue() {
        $this->setUpdated(new \DateTime());
    }

    public function assembleDisplayName() {
        $displayName = '';

        if ($this->gender == self::GENDER_MALE) {
            $displayName .= self::GENDER_MALE_DISPLAY_VALUE;
        } elseif ($this->gender == self::GENDER_FEMALE) {
            $displayName .= self::GENDER_FEMALE_DISPLAY_VALUE;
        }

        if ($this->namePrefix) {
            $displayName .= ' ' . $this->namePrefix;
        }

        $displayName .= ' ' . $this->firstName . ' ' . $this->lastName;

        return $displayName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set namePrefix
     *
     * @param string $namePrefix
     * @return User
     */
    public function setNamePrefix($namePrefix)
    {
        $this->namePrefix = $namePrefix;

        return $this;
    }

    /**
     * Get namePrefix
     *
     * @return string
     */
    public function getNamePrefix()
    {
        return $this->namePrefix;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set lifePartner
     *
     * @param \JCV\UserBundle\Entity\User $lifePartner
     * @return User
     */
    public function setLifePartner(\JCV\UserBundle\Entity\User $lifePartner = null)
    {
        $this->lifePartner = $lifePartner;

        return $this;
    }

    /**
     * Get lifePartner
     *
     * @return \JCV\UserBundle\Entity\User
     */
    public function getLifePartner()
    {
        return $this->lifePartner;
    }

    /**
     * Add myFriends
     *
     * @param \JCV\UserBundle\Entity\User $myFriends
     * @return User
     */
    public function addMyFriend(\JCV\UserBundle\Entity\User $myFriends)
    {
        $this->myFriends[] = $myFriends;

        return $this;
    }

    /**
     * Remove myFriends
     *
     * @param \JCV\UserBundle\Entity\User $myFriends
     */
    public function removeMyFriend(\JCV\UserBundle\Entity\User $myFriends)
    {
        $this->myFriends->removeElement($myFriends);
    }

    /**
     * Get myFriends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyFriends()
    {
        return $this->myFriends;
    }

    /**
     * Set image
     *
     * @param \JCV\UserBundle\Entity\Image $image
     * @return User
     */
    public function setImage(\JCV\UserBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \JCV\UserBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    public function eraseCredentials() {

    }
     /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles() {

        return $this->roles;
    }

         /**
     * Get rolesAsArray
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRolesAsArray() {
        $roleArray = array();
        foreach ($this->roles as $role) {
//            $roleArray[] = $role->getLabel();
            $roleArray[] = $role;
        }
        return $roleArray;

    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
