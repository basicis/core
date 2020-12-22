<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\ResponseFactory;
use Basicis\Http\Message\Response;

/**
 *  classTest\Http\Message\ResponseFactoryTest
 */
class ResponseFactoryTest extends TestCase
{
    /**
     * testCreateResponse function
     *
     * @return void
     */
    public function testCreateResponse()
    {
        $factory = new ResponseFactory() ;
        $this->assertInstanceOf(Response::class, $factory->createResponse(200));
    }
}
