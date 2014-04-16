<?php

namespace JhUserTest\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class User extends AbstractFixture
{
    protected $user;

    /**
     * {inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->user = new User();
        $manager->persist($this->user);
        $manager->flush();
    }
} 