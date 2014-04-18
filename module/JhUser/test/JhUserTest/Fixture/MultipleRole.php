<?php

namespace JhUserTest\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use JhUser\Entity\Role;

/**
 * Class MultipleRole
 * @package JhUserTest\Fixture
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class MultipleRole extends AbstractFixture
{
    /**
     * @var Role[]
     */
    protected $roles;

    /**
     * @var Role
     */
    protected $parent;

    /**
     * {inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $parent = new Role();
        $parent->setRoleId('user');
        $manager->persist($parent);
        $this->parent = $parent;

        foreach(array('admin', 'manager') as $roleData) {
            $role = new Role;
            $role->setRoleId($roleData)
                ->setParent($parent);

            $manager->persist($role);
            $this->roles[] = $role;
        }

        $manager->flush();
    }

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return Role
     */
    public function getParent()
    {
        return $this->parent;
    }
} 