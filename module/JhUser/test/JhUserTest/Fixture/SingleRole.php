<?php

namespace JhUserTest\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use JhUser\Entity\Role;

/**
 * Class SingleRole
 * @package JhUserTest\Fixture
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class SingleRole extends AbstractFixture
{
    /**
     * @var Role
     */
    protected $role;

    /**
     * {inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->role = new Role();

        $this->role
            ->setId(1)
            ->setRoleId('admin');

        $manager->persist($this->role);
        $manager->flush();
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
} 