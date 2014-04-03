<?php

namespace JhUserTest\Entity;

use JhUser\Entity\Role;

/**
 * Class RoleTest
 * @package JhUserTest\Entity
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class RoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Role
     */
    protected $role;

    /**
     * SetUp
     */
    public function setUp()
    {
        $this->role = new Role;
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

        $this->assertNull($this->role->$getMethod());
        $this->role->$setMethod($value);
        $this->assertSame($value, $this->role->$getMethod());
    }

    /**
     * @return array
     */
    public function setterGetterProvider()
    {
        return array(
            array('id'          , 1),
            array('roleId'      , 'admin'),
            array('parent'      , new Role),
        );
    }
}