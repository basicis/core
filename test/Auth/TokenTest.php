<?php
namespace Test\Auth;

use PHPUnit\Framework\TestCase;
use Basicis\Auth\Token;
use Basicis\Auth\User;

/**
 * Class TokenTest
 */

class TokenTest extends TestCase
{

    /**
     * $token variable
     *
     * @var string
     */
    private $token;

    /**
     * $appKey variable
     *
     * @var string
     */
    private $appKey;


    /**
     * $tokenObj variable
     *
     * @var Token
     */
    private $tokenObj;


    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set("America/Recife");
        $this->tokenObj = new Token("my-app-key-here", "Basicis Framework", "+30 minutes", "now");

        $user = new User();
        $user->setUsername("my_username");
        $user->setRole(1);

        $this->token = $this->tokenObj->create($user);
    }


    /**
     * Function testConstruct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Token::class, $this->tokenObj);
    }


    /**
     * Function testCreate
     *
     * @return void
     */
    public function testCreate()
    {
        $this->assertEquals(true, count(explode(".", $this->token)) === 3);
    }


    /**
     * Function testDecode
     *
     * @return void
     */
    public function testDecode()
    {
        $tokenDecode =  $this->tokenObj->decode($this->token);
        if ($tokenDecode !== null) {
            return $this->assertEquals("my_username", $tokenDecode->usr->username);
        }
        $this->assertEquals("my_username", null);
    }


    /**
     * Function testCheck
     *
     * @return void
     */
    public function testCheck()
    {
        $this->assertEquals(true, $this->tokenObj->check($this->token));
    }
}
