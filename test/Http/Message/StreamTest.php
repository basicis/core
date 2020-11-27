<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\Stream;
use Basicis\Http\Message\StreamFactory;

 /**
* classTest\Http\Message\StreamTest
 */

class StreamTest extends TestCase
{
    private $stream;

     /**
    * __construct function
    */
    public function __construct()
    {
        parent::__construct();
        $this->stream = (new StreamFactory())->createStream("Test stream content.");
    }

    /**
    * testConstruct function
    *
    * @return void
    */
    public function testConstruct()
    {
        //test new instance of Stream
        $this->assertInstanceOf(Stream::class, $this->stream);
    }

    /**
     * testToString function
     *
     * @return void
     */
    public function testToString()
    {
        $this->assertEquals(true, is_string($this->stream->__toString()));
    }
}
