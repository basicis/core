<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\Uri;

/**
 *  classTest\Http\Message\UriTest
 */
class UriTest extends TestCase
{

    private $uri;

    /**
     * __construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->uri = new Uri();
    }

     /**
     * testContruct function
     * Check if self::Uri() is an new instance of Basicis\Http\Uri
     * @return void
     */
    public function testContruct()
    {
        $this->assertInstanceOf(Uri::class, $this->uri);
    }

    /**
     * testScheme function
     * Check Uri::getScreme()
     * @return void
     */
    public function testGetScheme()
    {
        //without scheme especification
        $this->assertEquals('http', $this->uri->getScheme());
    }

    /**
     * testWithScheme function
     * Check Uri::withScreme()
     * @return void
     */
    public function testWithScheme()
    {
        //String scheme http
        $uri = $this->uri->withScheme('https');
        $this->assertInstanceOf(Uri::class, $uri);
        $this->assertEquals('https', $uri->getScheme());
    }

    /**
     * testAuthority function
     * Check Uri::getAuthority()
     * @return void
     */
    public function testAuthority()
    {
         //with empty host
         $this->assertEquals('localhost', $this->uri->getAuthority());
    }


    /**
     * testGetUserInfo function
     * Check Uri::getUserInfo()
     * @return void
     */
    public function testGetUserInfo()
    {

        //With user and password credencials
        $this->assertinstanceOf(Uri::class, $this->uri->withUserinfo('messias', '12345'));
        $this->assertEquals('messias:12345', $this->uri->getUserInfo());
        
        //With user and without password credencials
        $this->uri->withUserinfo('messias');
        $this->assertEquals('messias', $this->uri->getUserInfo());

        //Without user or password credencials
        $this->uri->withUserinfo('');
        $this->assertEquals('', $this->uri->getUserInfo());
    }


    /**
     * testHost function
     * Check Uri::getHost()
     * @return void
     */
    public function testHost()
    {
        //without host especification
        $this->assertEquals('localhost', $this->uri->getHost());
    }


    /**
     * testHost function
     * Check Uri::withHost()
     * @return void
     */
    public function testWithHost()
    {
        //with host especification
        $uri = $this->uri->withHost('local');
        $this->assertInstanceOf(Uri::class, $uri);
        $this->assertEquals('local', $uri->getHost());
        $this->assertEquals($uri->getAuthority(), 'local');
    }



     /**
     * testPort function
     * Check Uri::getPort()
     * @return void
     */
    public function testPort()
    {
        //without especification
        $this->assertEquals(null, $this->uri->getPort());

        //with especification
        $this->uri->withPort(443);
        $this->assertEquals(443, $this->uri->getPort(true));
    }




     /**
     * testPath function
     * Check Uri::getPath()
     * @return void
     */
    public function testPath()
    {
        //Check home as '/' Path
        $this->assertEquals('/', $this->uri->getPath());

        //Check test as '/test' Path
        $this->uri->withPath('/test');
        $this->assertInstanceOf(Uri::class, $this->uri);
        $this->assertEquals('/test', $this->uri->getPath());
    }




    /**
     * testFragment function
     * Check Uri::getFragment()
     * @return void
     */
    public function testFragment()
    {
        //Check Fragment ''
        $this->assertEquals('', $this->uri->getFragment());

        //Check Fragment test as '#test'
        $this->uri->withFragment('test');
        $this->assertInstanceOf(Uri::class, $this->uri);
        $this->assertEquals('test', $this->uri->getFragment());
    }


     /**
     * testQuery function
     * Check Uri::getQuery()
     * @return void
     */
    public function testQuery()
    {
        //Check with empty query string
        $this->assertEquals('', $this->uri->getQuery());

        //Check with 'test=1234' query string
        $this->uri->withQuery('test=1234&');
        $this->assertEquals('test=1234', $this->uri->getQuery());
    }
}
