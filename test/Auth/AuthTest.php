<?php
namespace Test\Auth;

use PHPUnit\Framework\TestCase;

use Basicis\Basicis as App;
use Basicis\Auth\Token;
use Basicis\Auth\Auth;
use Basicis\Auth\User;
use Basicis\Auth\AuthInterface;
use Basicis\Http\Message\ServerRequestFactory;

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
    private $appKey = "ficticious*app#key%here";

    /**
     * $pass variable
     *
     * @var string
     */
    private $pass = "1234cbv";

    /**
     *  $request variable
     *
     * @var serverRequestInterface
     */
    private $request;

    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->pass = "1234cbv";
        $this->user
            ->setFirstName("Jhon")
            ->setLastName("Snow")
            ->setEmail("jhon@test.com")
            ->setPass($this->pass)
            ->setRole(5);
        $this->user->save();

        $this->request = (ServerRequestFactory::create("get", "/"))
                            ->withAttribute("appKey", $this->appKey);

        $token = new Token(
            $this->request->getAttribute("appKey"),
            $this->request->getAttribute("tokenIss"),
            $this->request->getAttribute("tokenExpiration"),
            $this->request->getAttribute("tokenNobefore")
        );

        $this->request->withHeader("authorization", $token->create($this->user));
    }

    /**
     * Function testLogin
     *
     * @return void
     */
    public function testLogin()
    {
        $token = Auth::login(
            $this->request,
            $this->user
        );
        $this->assertNotEmpty($token);
        $this->user->delete();
    }

    /**
     * Function testLogin
     *
     * @return void
     */
    public function testGetUser()
    {
        $user = Auth::getUser($this->request, User::class);
        $this->assertEquals("jhon@test.com", $this->user->getEmail());
        $this->assertTrue($this->user->delete());
    }
}
