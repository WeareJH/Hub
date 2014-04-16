<?php

namespace JhUserTest\Entity;

use JhUser\Entity\Role;
use JhUser\Entity\User;

/**
 * Class UserTest
 * @package JhUserTest\Entity
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class UserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var User
     */
    protected $user;

    /**
     * SetUp
     */
    public function setUp()
    {
        $this->user = new User;
    }

    /**
     * Test the setter/getters
     *
     * @param        string $name
     * @param        mixed  $value
     *
     * @dataProvider setterGetterProvider
     */
    public function testSetterGetter($name, $value)
    {
        $getMethod = 'get' . ucfirst($name);
        $setMethod = 'set' . ucfirst($name);

        $this->assertNull($this->user->$getMethod());
        $this->user->$setMethod($value);
        $this->assertSame($value, $this->user->$getMethod());
    }

    /**
     * @return array
     */
    public function setterGetterProvider()
    {
        return array(
            array('id'          , 1),
            array('email'       , 'aydin@wearejh.com'),
            array('username'    , 'aydin'),
            array('username'    , 'aydin'),
            array('displayName' , 'Aydin'),
            array('state'       , null),
            array('createdAt'   , new \DateTime),
            array('createdAt'   , new \DateTime),
            array('password'    , 'password'),


        );
    }

    public function testAddRole()
    {
        $user = new User;

        $role1 = new Role;
        $role2 = new Role;

        $user->addRole($role1);
        $this->assertContains($role1, $user->getRoles());

        $user->addRole($role2);
        $this->assertContains($role1, $user->getRoles());
        $this->assertContains($role2, $user->getRoles());
    }

    public function testPrePersistCreatedAtDateInstanceOfDateTime()
    {
        $user = new User;
        $this->assertNull($user->getCreatedAt());
        $user->setCreatedAtDate();

        $this->assertInstanceOf('DateTime', $user->getCreatedAt());
    }

    public function testJsonSerializeUser()
    {
        $user = new User;
        $user->setId(1)
            ->setDisplayName("Aydin Hassan")
            ->setState(null)
            ->setEmail("aydin@wearejh.com");

        $expected = array(
            'id'    => 1,
            'name'  => 'Aydin Hassan',
            'state' => null,
            'email' => 'aydin@wearejh.com'
        );

        $this->assertEquals($expected, $user->jsonSerialize());
    }
}