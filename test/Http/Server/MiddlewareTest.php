<?php
namespace Test\Http\Server;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Server\Middleware;
use Basicis\Http\Server\ExampleMiddleware;
use Basicis\Http\Message\ServerRequestFactory;
use Basicis\Http\Message\ResponseFactory;

/**
 * ClassTest\Http\Server\MiddlewareTest
 *
 */
class MiddlewareTest extends TestCase
{
    /**
     * $middleware variable
     *
     * @var ExampleMiddleware
     */
    private $middleware;

    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware = new ExampleMiddleware();
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
     * Function testProcess
     *
     * @return void
     */
    public function testProcess()
    {
        //Basicis\Http\Server\ExampleMiddleware
        $this->assertInstanceOf(
            ResponseInterface::class,
            $this->middleware->process(
                ServerRequestFactory::create("get", "/"),
                ResponseFactory::create()
            )
        );
    }
}
