<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\Request;
use Basicis\Http\Message\Uri;

/**
 *  classTest\Http\Message\RequestTest
 */
class RequestTest extends TestCase
{

    private $request;

    /**
     * __construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->request = new Request();
    }

    /**
     * testConstruct function
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Request::class, $this->request);
    }

    /**
     * testGetRequestTarget function
     *
     * @return void
     */
    public function testGetRequestTarget()
    {
        //without target especification
        $this->assertEquals('/', $this->request->getRequestTarget());
    }


    /**
     * testWithRequestTarget function
     *
     * @return void
     */
    public function testWithRequestTarget()
    {
        //with target especification
        $request = $this->request->withRequestTarget('/home');
        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('/home', $request->getRequestTarget());
    }

    /**
     * testGetMethod function
     *
     * @return void
     */
    public function testGetMethod()
    {
        //without method especification
        $this->assertEquals('GET', $this->request->getMethod());
    }


    /**
     * testWithMethod function
     *
     * @return void
     */
    public function testWithMethod()
    {
        //with method especification
        $request = $this->request->withMethod('post');
        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('POST', $request->getMethod());
    }

    /**
     * testGetUri function
     *
     * @return void
     */
    public function testGetUri()
    {
        //without Uri especification
        $this->assertInstanceOf(Uri::class, $this->request->getUri());
    }


    /**
     * testWithUri function
     *
     * @return void
     */
    public function testWithUri()
    {
        //with Uri especification
        $uri = new Uri();

        $this->assertInstanceOf(Request::class, $this->request->withUri($uri->withHost('localhost')));
        $this->assertEquals('localhost', $this->request->getUri()->getHost());
      
        $this->request->withUri($uri->withHost('myhost'), true);
        $this->assertEquals('myhost', $this->request->getUri()->getHost());
    }
}
