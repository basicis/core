<?php
namespace Test\Http\Server;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Server\ExampleMiddleware;
use Basicis\Basicis as App;

/**
 * ClassTest\Http\Server\ExampleMiddlewareTest
 *
 */
class ExampleMiddlewareTest extends TestCase
{
    /**
     * $app variable
     *
     * @var App
     */
    private $app;

    /**
     * $example variable
     *
     * @var ExampleMiddleware
     */
    private $example;

    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->app = App::createApp();
        $this->example = new ExampleMiddleware($this->app);
    }

    /**
     * Function testConstruct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ExampleMiddleware::class, $this->example);
    }

    /**
     * Function testHandler
     *
     * @return void
     */
    public function testHandler()
    {
        $response = $this->example->handle($this->app->getRequest());
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(202, $response->getStatusCode());
    }
}
