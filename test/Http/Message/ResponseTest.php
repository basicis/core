<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\Response;
use Basicis\Http\Message\Uri;

class ResponseTest extends TestCase
{

    private $response;

    /**
     * __construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->response = new Response();
    }

    /**
     * testGetStatusCode function
     *
     * @return void
     */
    public function testGetStatusCode()
    {
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    //withStatus

    /**
     * testGetStatusCode function
     *
     * @return void
     */
    public function testWithStatusCode()
    {
        $this->response = $this->response->withStatus(101);
        $this->assertEquals(101, $this->response->getStatusCode());
    }

    /**
     * testGetReasonPhrase function
     *
     * @return void
     */
    public function testGetReasonPhrase()
    {
        $this->response->withStatus(200);
        $this->assertEquals('Ok, working as expected!', $this->response->getReasonPhrase());
        $this->response->withStatus(100, "Continue custom reason");
        $this->assertEquals("Continue custom reason", $this->response->getReasonPhrase());
    }
}
