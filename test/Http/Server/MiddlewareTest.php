<?php
namespace Test\Http\Server;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Server\Middleware;
use Basicis\Http\Server\ExampleMiddleware;
use Basicis\Http\Server\RequestHandler;
use Basicis\Basicis as App;

/**
 * ClassTest\Http\Server\MiddlewareTest
 *
 */
class MiddlewareTest extends TestCase
{
    /**
     * $app variable
     *
     * @var App
     */
    private $app;

    /**
     * $middleware variable
     *
     * @var Middleware
     */
    private $middleware;

    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->app = App::createApp();
        $this->middleware = new Middleware($this->app, ["Basicis\Http\Server\ExampleMiddleware"]);
    }

    /**
     * Function testConstruct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Middleware::class, $this->middleware);
    }

    /**
     * Function testHandler
     *
     * @return void
     */
    public function testHandler()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->middleware->handle($this->app->getRequest()));
    }

    /**
     * Function testProcess
     *
     * @return void
     */
    public function testProcess()
    {
        $this->assertInstanceOf(
            ResponseInterface::class,
            $this->middleware->process($this->app->getRequest(), new RequestHandler($this->app))
        );
    }

    /**
     * Function testRun
     *
     * @return void
     */
    public function testRun()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->middleware->run());
    }
}
