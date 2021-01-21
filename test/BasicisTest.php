<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Basicis\Basicis as App;
use Basicis\Http\Message\ServerRequestFactory;
use Basicis\Http\Message\ServerRequest;
use Basicis\Http\Message\Response;
use Basicis\Controller\ExampleController;
use Basicis\Http\Server\ExampleMiddleware;
use Basicis\Router\Router;
use Basicis\Router\Route;
use Basicis\Auth\Auth;
use Basicis\Auth\Token;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BasicisTest
 */
class BasicisTest extends TestCase
{
    /**
     * $app variable
     *
     * @var App
     */
    private $app;

    /**
     * $appArguments variable
     *
     * @var array
     */
    private $appArguments;

    public function __construct()
    {
        parent::__construct();
        $this->app = App::createApp(ServerRequestFactory::create("GET", "/"));
    }

    /**
     * Function testConstruct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(App::Class, $this->app);
    }


    /**
     * Function testCreateApp
     *
     * @return void
     */
    public function testCreateApp()
    {
        $this->assertInstanceOf(App::class, App::createapp());
    }


    /**
     * Function testSetControllers
     *
     * @return void
     */
    public function testSetAndGetControllers()
    {
        $this->assertInstanceOf(
            App::class,
            $this->app->setControllers(
                [
                    "example" => "Basicis\\Controller\\ExampleController",
                    "example2" => new ExampleController()
                ]
            )
        );

        $this->assertInstanceOf(
            ExampleController::class,
            $this->app->getController("example")
        );

        $this->assertInstanceOf(
            ExampleController::class,
            $this->app->getController("example2")
        );

        $this->app->setRoutesByAnnotations("Basicis\Controller\ExampleController");
    }


    /**
     * Function testSetAndGetMiddlewares
     *
     * @return void
     */
    public function testSetAndGetMiddlewares()
    {
        $this->assertInstanceOf(
            App::class,
            $this->app->setBeforeMiddlewares(["Basicis\Http\Server\ExampleMiddleware"])
        );

        //Required an middleware indentification key
        $this->assertInstanceOf(
            App::class,
            $this->app->setRouteMiddlewares(["example" => "Basicis\Http\Server\ExampleMiddleware"])
        );

        $this->assertInstanceOf(
            App::class,
            $this->app->setAfterMiddlewares(["Basicis\Http\Server\ExampleMiddleware"])
        );

        $middlewares = $this->app->getMiddlewares();
        $this->assertEquals(["Basicis\Http\Server\ExampleMiddleware"], $middlewares["before"]);
        $this->assertEquals(["Basicis\Http\Server\ExampleMiddleware"], $middlewares["after"]);
        $this->assertEquals(["example" => "Basicis\Http\Server\ExampleMiddleware"], $middlewares["route"]);
    }

    /**
     * Function testSetMode
     *
     * @return void
     */
    public function testSetMode()
    {
        $this->assertInstanceOf(App::class, $this->app->setMode("dev"));
    }

    /**
     * Function testSetTimezone
     *
     * @return void
     */
    public function testSetAndGetModeAndTimezone()
    {
        //App Mode Production
        $this->assertInstanceOf(App::class, $this->app->setMode("production"));
        $this->assertEquals("production", $this->app->getMode());

        //App Mode Development
        $this->assertInstanceOf(App::class, $this->app->setMode('dev'));
        $this->assertEquals("dev", $this->app->getMode());

        //App Timezone
        $this->assertInstanceOf(App::class, $this->app->setTimezone("America/Recife"));
        $this->assertEquals("America/Recife", $this->app->getTimezone());
    }

    /**
     * Function testSetRequest
     *
     * @return void
     */
    public function testSetRequest()
    {
        $this->app->setRequest(ServerRequestFactory::create("GET", "/url"));
        $this->assertEquals("/url", $this->app->getRequest()->getUri()->getPath());

        $this->app->setRequestByArray([
            "method" => "GET",
            "uri" => "http://localhost:8080/my-path"
        ]);
        $this->assertEquals(
            "http://localhost:8080/my-path",
            $this->app->getRequest()->getUri()->__toString()
        );

        $this->app->setRequestByArray([
            "method" => "GET",
            "protocol" => "http",
            "host" => "localhost",
            "port" => "8080",
            "path" => "/my-path2",
            "headers" => ["test" => "Ok!"]
            
        ]);
        $this->assertEquals(
            "http://localhost:8080/my-path2",
            $this->app->getRequest()->getUri()->__toString()
        );
        $this->assertEquals("Ok!", $this->app->getRequest()->getHeader("test")[0]);
    }

    /**
     * Function testGetRequest
     *
     * @return void
     */
    public function testGetRequest()
    {
        $this->assertInstanceOf(ServerRequest::class, $this->app->getRequest());
    }

     /**
     * Function testGetResponse
     *
     * @return void
     */
    public function testGetResponse()
    {
        $response = $this->app->response(201);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->app->setResponse(200);
        $this->assertEquals(200, $this->app->getResponse()->getStatusCode());
    }

    /**
     * Function testGetRouter
     *
     * @return void
     */
    public function testGetRouter()
    {
        $this->assertInstanceOf(Router::class, $this->app->getRouter());
    }


    /**
     * Function testGetRoute
     *
     * @return void
     */
    public function testGetRoute()
    {
        $this->assertEquals(null, $this->app->getRoute());
        $this->app->setRoute("/", "get", function () {
            return $app->response(200);
        });

        $this->assertInstanceOf(Route::class, $this->app->getRoute());
    }

    /**
     * Function testAuth
     *
     * @return void
     */
    public function testAuth()
    {
        //Setup Test, setting appKey
        $this->app->setAppKey("test-app-key-here");

        //Creating a instanceof Token and a instanceof Auth (user)
        $tokenObj = new Token($this->app->getAppKey(), "Test Iss", "+10 minutes", "now");
        $user = new Auth();

        //Setting Auth (user) params
        $user->setEmail("user@test.com")->setRole(5)->setPass("1234")->save();
        //Creating a string token, with $user obj as params
        $tokenString = $tokenObj->create($user);

        //Setting this string token to a instanceof ServerRequestInterface in the Basicis App
        //In the actual operation of the application,
        //it must reach the same via http header in the format 'Authorization: Bearer <You-access-token-here>'
        $this->app->setRequest($this->app->request()->withHeader("authorization", "Bearer ".$tokenString));
        
        //Exec tests assertions
        $this->assertEquals(null, $this->app->auth());
        $this->assertInstanceOf(Auth::class, $this->app->auth("Basicis\Auth\Auth"));
        $this->assertEquals(true, $user->delete()); //delete test user
        $this->assertEquals(null, Auth::all()); //check if all is removed
    }


    /**
     * Function testRunAndResponse
     *
     * @return void
     */
    public function testRunAndResponse()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->app->runAndResponse());
    }
}
