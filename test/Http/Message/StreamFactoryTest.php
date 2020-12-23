<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Basicis\Http\Message\StreamFactory;

/**
 *  classTest\Http\Message\StreamFactoryTest
 */
class StreamFactoryTest extends TestCase
{
    private $streamFactory;

    public function __construct()
    {
        parent::__construct();
        $this->streamFactory = new StreamFactory();
    }

    /**
     * testCreateStream function
     *
     * @return void
     */
    public function testCreateStream()
    {
        $this->assertinstanceOf(StreamInterface::class, $this->streamFactory->createStream());
    }

    /**
     * testCreateStreamFromFile function
     *
     * @return void
     */
    public function testCreateStreamFromFile()
    {
        $this->assertinstanceOf(
            StreamInterface::class,
            $this->streamFactory->createStreamFromFile('php://temp')
        );
    }

    /**
     * testCreateStreamFromResource function
     *
     * @return void
     */
    public function testCreateStreamFromResource()
    {
        $this->assertinstanceOf(
            StreamInterface::class,
            $this->streamFactory->createStreamFromResource(fopen('php://temp', 'r'))
        );
    }
}
