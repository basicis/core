<?php
namespace Test\Router;

use PHPUnit\Framework\TestCase;
use Basicis\Router\Router;
use Basicis\Router\Route;
use Basicis\Http\Message\ServerRequestFactory;
use Basicis\Http\Message\ResponseFactory;
use Basicis\Basicis as App;

 /**
 * Class Test\RouterTest
 *
 */

class RouterTest extends TestCase
{
    /**
     * $router variable
     *
     * @var Router
     */
    private $router;

    /**
     * $route variable
     *
     * @var Route
     */
    private $route;

    /**
    * Function __construct
    */
    public function __construct()
    {
        parent::__construct();
        $request = ServerRequestFactory::create("GET", "/");
        $response = ResponseFactory::create();

        $this->router = new Router();
        $this->router->setRequest(ServerRequestFactory::create("GET", "/"));

        $this->router->setRoute("/", "GET", function () {
            return true;
        });

        $this->router->setRoute("/test", "GET", function () {
            return true;
        });

        $this->route = $this->router->getRoute();
    }


    /**
    * Function testConstruct
    *
    * @return void
    */
    public function testConstruct()
    {
        $this->assertInstanceOf(Router::class, $this->router);
    }


    /**
    * Function testGetRoute
    *
    * @return void
    */
    public function testGetRoute()
    {
        $this->assertInstanceOf(Route::class, $this->route);
    }



    /**
    * Function testGetRouteName
    *
    * @return void
    */
    public function testGetRouteName()
    {
        $this->assertEquals("/", $this->route->getName());
    }


    /**
    * Function testGetRouteMethod
    *
    * @return void
    */
    public function testGetRouteMethod()
    {
        $this->assertEquals("GET", $this->route->getMethod());
    }

    /**
     * Function testHasRoute
     *
     * @return void
     */
    public function testHasRoute()
    {
        $this->assertEquals(true, $this->router->hasRoute("/", "GET"));
        $this->assertEquals(true, $this->router->hasRoute("/test", "GET"));
    }
}
