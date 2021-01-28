<?php
namespace Test\Auth;

use PHPUnit\Framework\TestCase;
use Basicis\Auth\User;

/**
 * Class UserTest
 */
class UserTest extends TestCase
{
    /**
     * $user variable
     *
     * @var User
     */
    private $user;

    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->pass = "1234cbv";
        $this->user
            ->setFirstName("Fred")
            ->setLastName("Armsterdam")
            ->setEmail("fred@test.com")
            ->setPass($this->pass)
            ->setRole(1);
        $this->user ->save();
    }

    /**
     * Function testSetAndGetUsername
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(User::class, $this->user);
    }

    /**
     * Function testSetUsername
     *
     * @return void
     */
    public function testSetAndGetUsername()
    {
        $this->assertInstanceOf(User::class, $this->user->setUsername("my_username2"));
        $this->assertEquals("my_username2", $this->user->getUsername());
    }

    /**
     * Function testSetAndGetEmail
     *
     * @return void
     */
    public function testSetAndGetEmail()
    {
        $this->assertInstanceOf(User::class, $this->user->setEmail("im2@test.com"));
        $this->assertEquals("im2@test.com", $this->user->getEmail());
        $this->assertEquals("fred@test.com", $this->user->getUsername());
    }

    /**
     * Function testSetAndGetPass
     *
     * @return void
     */
    public function testSetAndGetPass()
    {
        $this->assertInstanceOf(User::class, $this->user->setPass("4321"));
        $this->assertEquals(true, $this->user->checkPass("4321"));
    }


    /**
     * Function testGetAndGetRole
     *
     * @return void
     */
    public function testGetAndGetRole()
    {
        $this->assertInstanceOf(User::class, $this->user->setRole(1));
        $this->assertEquals(1, $this->user->getRole());
        $this->assertEquals("god", $this->user->getRoleName());
    }

    /**
     * Function testCreate
     *
     * @return void
     */
    public function testCreate()
    {
        $user = User::findOneBy(["email" => $this->user->getEmail()]);
        $this->assertEquals($this->user->getEmail(), $user->getEmail());
    }

    /**
     * Function testUpdate
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->user->setRole(5)->save();
        $this->assertEquals(5, $this->user->getRole());
    }

    /**
     * Function testDelete
     *
     * @return void
     */
    public function testDelete()
    {
        $this->assertTrue($this->user->delete());
    }
}
