<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\ServerRequest;
use Basicis\Http\Message\UploadedFile;
 
/**
 *  classTest\Http\Message\ServerRequestTest
 */
class ServerRequestTest extends TestCase
{
    private $server;

    public function __construct()
    {
        parent::__construct();
        $this->server = new ServerRequest();
    }

    /**
     * testGetServerParams function
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceof(ServerRequest::class, $this->server);
    }

    /**
     * testGetServerParams function
     *
     * @return void
     */
    public function testGetServerParams()
    {
        $this->assertEquals(true, is_array($this->server->getServerParams()));
    }

    /**
     * testGetCookieParams function
     *
     * @return void
     */
    public function testGetCookieParams()
    {
        $this->assertEquals(true, is_array($this->server->getCookieParams()));
    }


    /**
     * testeWithCookieParams function
     *
     * @return void
     */
    public function testWithCookieParams()
    {
        $array_cookies = ["my_cookie" => "Cookie test Ok!"];
        $this->server->withCookieParams($array_cookies);
        $this->assertEquals($array_cookies, $this->server->getCookieParams());
    }


     /**
     * testWithQueryParams function
     *
     * @return void
     */
    public function testWithQueryParams()
    {
        $this->server->withQueryParams(['test' => "ok"]);
        $this->assertEquals(
            true,
            is_array($this->server->getQueryParams()) && (count($this->server->getQueryParams()) == 1)
        );
    }

    /**
     * testGetQueryParams function
     *
     * @return void
     */
    public function testGetQueryParams()
    {
        $this->server->withQueryParams(['test2' => "ok"]);
        $this->assertEquals(['test2' => "ok"], $this->server->getQueryParams());
    }


    /**
     * testGetUploadedFiles function
     *
     * @return void
     */
    public function testGetUploadedFiles()
    {
        $this->assertEquals(true, is_array($this->server->getUploadedFiles()));
    }

    /**
     * testWithUploadedFiles function
     *
     * @return void
     */
    public function testWithUploadedFiles()
    {
        $files = [
            [
                "size" => 10,
                "error" => 0,
                "tmp_name" => @tempnam("/tmp", "tmpf"),
                "type" => "image/png",
                "name" => "test1.png"
            ],
            [
                "size" => 25,
                "error" => 0,
                "tmp_name" => @tempnam("/tmp", "tmpf"),
                "type" => "image/png",
                "name" => "test2.png"
            ]
        ];

        $this->server->withUploadedFiles($files);
        $uploadedFiles = $this->server->getUploadedFiles();

        foreach ($uploadedFiles as $file) {
            $this->assertInstanceOf(UploadedFile::class, $file);
        }
    }

    /**
     * testGetParsedBody function
     *
     * @return void
     */
    public function testGetParsedBody()
    {
        $this->assertEquals(null, $this->server->getParsedBody());
    }

    /**
     * testeWithParsedBody function
     *
     * @return void
     */
    public function testWithParsedBody()
    {
        $this->server->withParsedBody("test=ok");
        $this->assertEquals(["test" => "ok"], $this->server->getParsedBody());
        $this->server->withParsedBody("test=ok&test2=ok2");
        $this->assertEquals(["test" => "ok", "test2" => "ok2"], $this->server->getParsedBody());
    }

    /**
     * testGetAttributes function
     *
     * @return void
     */
    public function testGetAttributes()
    {
        $this->assertEquals([], $this->server->getAttributes());
    }

    /**
     * testGetAttribute function
     *
     * @return void
     */
    public function testGetAttribute()
    {
        $this->assertEquals(null, $this->server->getAttribute("test"));
    }

    /**
     * testWithAttribute function
     *
     * @return void
     */
    public function testWithAttribute()
    {
        $this->server->withAttribute("test", "ok");
        $this->assertEquals("ok", $this->server->getAttribute("test"));
    }

    /**
     * testWithoutAttribute function
     *
     * @return void
     */
    public function testWithoutAttribute()
    {
        $this->server->withAttribute("test", "ok");
        $this->server->withAttribute("test2", "ok2");
        $this->server->withoutAttribute("test");
        $this->assertEquals(["test2" => "ok2"], $this->server->getAttributes());
    }
}
