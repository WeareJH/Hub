<?php

namespace JhHub\Installer;

use Doctrine\Common\Persistence\ObjectManager;
use JhUser\Entity\Permission;
use JhUser\Repository\PermissionRepositoryInterface;
use JhUser\Repository\RoleRepositoryInterface;
use JhUser\Entity\HierarchicalRole;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Class RoleInstaller
 * @package JhHub\Installer
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleInstaller implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * @var RoleRepositoryInterface
     */
    protected $roleRepository;

    /**
     * @var PermissionRepositoryInterface
     */
    protected $permissionRepository;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $roleConfig = array();

    /**
     * @param array $config
     * @param RoleRepositoryInterface $roleRepository
     * @param PermissionRepositoryInterface $permissionRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        array $config = array(),
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository,
        ObjectManager $objectManager
    ) {

        $this->objectManager        = $objectManager;
        $this->roleRepository       = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->roleConfig           = $config;
    }

    /**
     * Create the roles
     */
    public function installRoles()
    {
        $this->createRoles($this->roleConfig);
    }

    /**
     * Recursively create roles and assign permissions
     *
     * @param array $roles
     * @param HierarchicalRole $parentRole
     */
    public function createRoles(array $roles, HierarchicalRole $parentRole = null)
    {
        foreach ($roles as $roleName => $options) {

            if (is_numeric($roleName) && is_scalar($options)) {
                /*
                    this is possibly last role in the tree like:
                    'admin' => [
                        'children' => [
                            'user'
                        ],
                    ],
                */
                $role = $this->findOrCreateRole($options, $parentRole);
            } else {
                $role = $this->findOrCreateRole($roleName, $parentRole);
            }

            //Check if any permissions need to be added to the role
            if (isset($options['permissions']) && is_array($options['permissions'])) {
                $this->addPermissions($role, $options['permissions']);
            }

            //recursively add roles
            if (isset($options['children']) && is_array($options['children'])) {
                $this->createRoles($options['children'], $role);
            }
        }
    }

    /**
     * Locate a role by its name,
     * create it if it does not exist. Also if parent is passed in
     * and the role already exists, add it as a child to the parent
     *
     * @param string $roleName
     * @param HierarchicalRole $parentRole
     * @return HierarchicalRole
     */
    public function findOrCreateRole($roleName, HierarchicalRole $parentRole = null)
    {
        $role = $this->roleRepository->findByName($roleName);

        if (null === $role) {
            $role = new HierarchicalRole();
            $role->setName($roleName);
            $this->objectManager->persist($role);
            $this->getEventManager()->trigger('role.create', $this, ['role' => $roleName]);
        }

        if (null !== $parentRole) {

            $assignToParent = true;
            //if this is an existing role
            //check it doesn't already exist
            //as a child on the parent
            if ($role->getId()) {
                //only add the role as a child, if it is not already there
                $childOf = false;
                foreach ($parentRole->getChildren() as $childRole) {
                    if ($childRole->getName() === $role->getName()) {
                        $childOf = true;
                    }
                }

                //if not a child of parent row
                //add it
                $assignToParent = !$childOf;
            }

            if ($assignToParent) {
                $parentRole->addChild($role);
                $this->getEventManager()->trigger('role.assign', $this, [
                    'role'      => $roleName,
                    'parent'    => ($parentRole) ? $parentRole->getName() : null
                ]);
            }
        }

        $this->objectManager->flush();
        return $role;
    }

    /**
     * Add all the given permissions to a role
     *
     *
     * @param HierarchicalRole $role
     * @param array $permissions
     */
    public function addPermissions(HierarchicalRole $role, array $permissions)
    {
        foreach ($permissions as $permissionName) {
            if (!$role->hasPermission($permissionName)) {
                $permission = $this->findOrCreatePermission($permissionName);
                $role->addPermission($permission);

                $this->getEventManager()->trigger('permission.assign', $this, [
                    'role'          => $role->getName(),
                    'permission'    => $permissionName
                ]);
            }
        }
    }

    /**
     * Locate a permission by its name,
     * create it if it does not exist
     *
     * @param string $permissionName
     * @return Permission
     */
    public function findOrCreatePermission($permissionName)
    {
        $permission = $this->permissionRepository->findByName($permissionName);

        if (null === $permission) {
            $permission = new Permission($permissionName);
            $this->objectManager->persist($permission);
            $this->objectManager->flush();

            $this->getEventManager()->trigger('permission.create', $this, [
                'permission'    => $permission
            ]);
        }

        return $permission;
    }
}