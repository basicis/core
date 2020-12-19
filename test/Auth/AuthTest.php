<?php
namespace Test\Auth;

use PHPUnit\Framework\TestCase;

use Basicis\Basicis as App;
use Basicis\Auth\Token;
use Basicis\Auth\Auth;

/**
 * Class AuthTest
 */

class AuthTest extends TestCase
{

    /**
     * $token variable
     *
     * @var Token
     */
    private $token;

    /**
     * $appKey variable
     *
     * @var string
     */
    private $appKey = "fictitious*app#key%here";


    /**
     * $auth variable
     *
     * @var Auth
     */
    private $auth;


    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
    }


    /**
     * Function testSetAndGetUsername
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Auth::class, $this->auth);
    }


     /**
     * Function testSetUsername
     *
     * @return void
     */
    public function testSetAndGetUsername()
    {
        $this->assertInstanceOf(Auth::class, $this->auth->setUsername("my_username"));
        $this->assertEquals("my_username", $this->auth->getUsername());
    }

    /**
     * Function testSetAndGetEmail
     *
     * @return void
     */
    public function testSetAndGetEmail()
    {
        $this->assertInstanceOf(Auth::class, $this->auth->setEmail("eu@test.com"));
        $this->assertEquals("eu@test.com", $this->auth->getEmail());
        $this->assertEquals("eu@test.com", $this->auth->getUsername());
    }


     /**
     * Function testSetAndGetPass
     *
     * @return void
     */
    public function testSetAndGetPass()
    {
        $this->assertInstanceOf(Auth::class, $this->auth->setPass("1234"));
        $this->assertEquals(true, $this->auth->checkPass("1234"));
    }


    /**
     * Function testGetAndGetRole
     *
     * @return void
     */
    public function testGetAndGetRole()
    {
        $this->assertInstanceOf(Auth::class, $this->auth->setRole(1));
        $this->assertEquals(1, $this->auth->getRole());
        $this->assertEquals("god", $this->auth->getRoleName());
    }


     /**
     * Function testLogin
     *
     * @return void
     */
    public function testLogin()
    {
        $auth = new Auth();
        $pass = "1234cbv";
        $auth->setEmail("im@test.com")->setPass($pass)->setRole(5)->save();
        $this->assertEquals(3, count(explode(".", Auth::login($auth->getEmail(), $pass, $this->appKey))));
        $this->assertEquals(true, Auth::findOneBy(["email" => $auth->getEmail()])->delete());
    }

     /**
     * Function testLogin
     *
     * @return void
     */
    public function testGetUser()
    {
        $this->auth->setUsername("Antony Boss")
                    ->setEmail("antony_boss@test.com")
                    ->setRole(3)
                    ->setPass("okboss0987")
                    ->save();
        $token = (new Token($this->appKey, "Basics Core | Test"))->create($this->auth);
        $user = Auth::getUser($token, $this->appKey);
        $this->assertEquals("antony_boss@test.com", $user->getEmail());
        $user->delete();
        $this->assertEquals(null, Auth::all());
    }
}
