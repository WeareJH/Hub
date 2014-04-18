<?php

namespace JhUser\Entity;

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Role
 * @package JhUser\Entity
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 *
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role implements HierarchicalRoleInterface
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
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="role_id")
     */
    protected $roleId;

    /**
     * @var \JhUser\Entity\Role
     * 
     * @ORM\ManyToOne(targetEntity="JhUser\Entity\Role")
     */
    protected $parent;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return \JhUser\Entity\Role
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param string $roleId
     * @return \JhUser\Entity\Role
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (string) $roleId;
        return $this;
    }

    /**
     * @return \JhUser\Entity\Role
     */
    public function getParent()
    {
        return $this->parent;
    }

   /**
    * @param \JhUser\Entity\Role $parent
    * @return \JhUser\Entity\Role
    */
    public function setParent(Role $parent)
    {
        $this->parent = $parent;
        return $this;
    }
}
