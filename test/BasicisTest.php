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
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

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
        $response = $this->app->getResponse(201);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
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
        
        $this->app->get("/", function () { 
            return $app->response(200);
        });

        $this->assertInstanceOf(Route::class, $this->app->getRoute());
    }
    
}