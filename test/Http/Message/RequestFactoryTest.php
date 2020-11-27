<?php
namespace Test\Message\Http;
use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\RequestFactory;
use Basicis\Http\Message\Request;

/**
 *  classTest\Http\Message\RequestFactoryTest
 */
class RequestFactoryTest extends TestCase 
{
    /**
     * testCreateRequest function
     *
     * @return void
     */
    public function testCreateRequest()
    {
        $factory = new RequestFactory() ;
        $this->assertInstanceOf(Request::class, $factory->createRequest('GET', '/') );
    }
}