<?php
namespace Test\Http\Server;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Server\RequestHandler;
use Basicis\Basicis as App;

/**
 * ClassTest\Http\Server\RequestHandlerTest
 *
 */
class RequestHandlerTest extends TestCase
{
    /**
     * $handler variable
     *
     * @var RequestHandler
     */
    private $handler;

    /**
     * $app variable
     *
     * @var App
     */
    private $app;

    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->app = App::createApp();
        $this->handler = new RequestHandler($this->app);
    }

    /**
     * Function testConstruct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(RequestHandler::class, $this->handler);
    }

    /**
     * Function testHandler
     *
     * @return void
     */
    public function testHandler()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->handler->handle($this->app->getRequest()));
    }
}
