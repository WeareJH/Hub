<?php

namespace JhUser\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
use JsonSerializable;

/**
 * Class User
 * @package JhUser\Entity
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, ProviderInterface, JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true,  length=255, nullable=false)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true,  length=255, nullable=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="display_name", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="state", nullable=true)
     */
    protected $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="JhUser\Entity\Role")
     * @ORM\JoinTable(name="user_role",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    /**
     * Initialise the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return \JhUser\Entity\User
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return \JhUser\Entity\User
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return \JhUser\Entity\User
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return \JhUser\Entity\User
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = (string) $displayName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return \JhUser\Entity\User
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
        return $this;
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param int|null $state
     * @return \JhUser\Entity\User
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return \JhUser\Entity\User
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param Role $role
     * @return \JhUser\Entity\User
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'id'    => $this->id,
            'name'  => $this->displayName,
            'email' => $this->email,
            'state' => $this->state,
        );
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtDate()
    {
        $this->setCreatedAt(new \DateTime);
    }
}
