<?php

namespace JhUserTest\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use JhUser\Entity\User;

/**
 * Class MultipleUser
 * @package JhUserTest\Fixture
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class MultipleUser extends AbstractFixture
{
    /**
     * @var User[]
     */
    protected $users;

    /**
     * {inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $data = [
            [
                'email'       => 'aydin@hotmail.co.uk',
                'password'    => 'p$ssw0rd'
            ],
            [
                'email'       => 'aydin@wearejh.com',
                'password'    => 'p$ssw0rd'
            ],
        ];

        foreach($data as $userData) {
            $user = new User;
            $user->setEmail($userData['email'])
                ->setPassword($userData['password']);

            $manager->persist($user);
            $this->users[] = $user;
        }

        $manager->flush();
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
} 