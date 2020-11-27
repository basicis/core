<?php
namespace Test\Http\Message;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\Message;
use Basicis\Http\Message\Stream;

 /**
 * ClassTest\Http\Message\MessageTest
 *
 */

class MessageTest extends TestCase
{

    /**
     * $message variable
     *
     * @var Message
     */
    private $message;

    /**
    * __construct function
    */
    public function __construct()
    {
        parent::__construct();
        $this->message = new Message();
    }


    /**
    * testConstruct function
    *
    * @return void
    */
    public function testConstruct()
    {
        //test new instance of Message
        $this->assertInstanceOf(Message::class, $this->message);
    }


    /**
    * testGetProtocolVersion function
    *
    * @return void
    */
    public function testGetProtocolVersion()
    {
        //if without especification, return 1.1
        $this->assertEquals('1.1', $this->message->getProtocolVersion());
    }


    /**
    * testWithProtocolVersion function
    *
    * @return void
    */
    public function testWithProtocolVersion()
    {
        //'1.0' or '1.1' must be specified
        $this->message->withProtocolVersion('1.0');
        $this->assertEquals('1.0', $this->message->getProtocolVersion());
    }


    /**
    * testGetHeaders function
    *
    * @return void
    */
    public function testGetHeaders()
    {
        //return a empty array if no isset headers
        $this->assertEquals([], $this->message->getHeaders());
    }


    /**
    * testHasHeaders function
    *
    * @return void
    */
    public function testHasHeaders()
    {
        //return true if a headers has key 'token' or false
        $this->assertEquals(false, $this->message->hasHeader('token'));
    }

    /**
    * testGetHeader function
    *
    * @return void
    */
    public function testGetHeader()
    {
        /**
        * return a correspondent array if in headers has a 'token' key,
        * or  an empty array
        */
        $this->assertEquals([], $this->message->getHeader('token'));
    }

    /**
    * testGetHeaderLine function
    *
    * @return void
    */
    public function testGetHeaderLine()
    {
        $this->message->withHeader('token', 'token_test_value_to_rewrited');
        $this->message =  $this->message->withHeader('token', 'token_test_here');
        $this->assertEquals('Token: token_test_here', $this->message->getHeaderLine('token'));
    }


    /**
    * testWithHeader function
    *
    * @return void
    */
    public function testWithHeader()
    {
        $this->message->withHeader('token', 'token_test_here2');
        $this->assertEquals(['token_test_here2'], $this->message->getHeader('token'));
    }



    /**
    * testWithAddedHeader function
    *
    * @return void
    */
    public function testWithAddedHeader()
    {
        $this->message->withHeader('token', 'token_test_here2');
        $this->message->withAddedHeader('token', 'token_test_here3');
        $this->assertEquals(['token_test_here2', 'token_test_here3'], $this->message->getHeader('token'));
    }

    /**
    * testWithoutHeader function
    *
    * @return void
    */
    public function testWithoutHeader()
    {
        //return a empty array if unset header
        $this->message->withoutHeader('token');
        $this->assertEquals([], $this->message->getHeader('token'));
    }

    /**
    * testGetBody function
    *
    * @return void
    */
    public function testGetBody()
    {
        $stream = new Stream(fopen('php://temp', 'rw'), ['mode' => 'rw']) ;
        $this->message->withBody($stream);
        $this->assertInstanceof(Stream::class, $this->message->getBody());
    }


    /**
    * testWithBody function
    *
    * @return void
    */
    public function testWithBody()
    {
        $this->assertInstanceof(Stream::class, $this->message->getBody());
    }


    /**
     * testWithHeaders function
     *
     * @return void
     */
    public function testWithHeaders()
    {
        $this->message->withHeaders(['teste' => ['teste ok','teste ok2'] ]);
        $this->assertEquals(['teste' => ['teste ok','teste ok2']], $this->message->getHeaders());
    }
}
