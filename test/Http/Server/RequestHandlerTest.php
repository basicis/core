<?php
namespace Test\Http\Server;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Server\RequestHandler;
use Basicis\Http\Server\ExampleRequestHandler;
use Basicis\Http\Message\ServerRequestFactory;
use Basicis\Http\Message\ResponseFactory;

/**
 * Class Test\Http\Server\RequestHandlerTest
 *
 */
class RequestHandlerTest extends TestCase
{
    /**
     * $handler variable
     *
     * @var ExampleRequestHandler
     */
    private $handler;

    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->handler = new ExampleRequestHandler();
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
     * Function testHandle
     *
     * @return void
     */
    public function testHandle()
    {
        //Basicis\Http\Server\ExampleRequestHandler
        $this->assertInstanceOf(
            ResponseInterface::class,
            $this->handler->handle(
                ServerRequestFactory::create("get", "/"),
                ResponseFactory::create()
            )
        );
    }
}
