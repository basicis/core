<?php
namespace Test\Message\Http;
use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\ServerRequestFactory;
use Basicis\Http\Message\ServerRequest;

/**
 *  classTest\Http\Message\ServerRequestFactoryTest
 */
class ServerRequestFactoryTest extends TestCase 
{
    /**
     * testCreateServerRequest function
     *
     * @return void
     */
    public function testCreateServerRequest()
    {
        $factory = new ServerRequestFactory();
        $this->assertInstanceOf(ServerRequest::class, $factory->createServerRequest('GET', '/', []) );
    }
}

