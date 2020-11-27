<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\UploadedFileFactory;
use Basicis\Http\Message\UploadedFile;
use Basicis\Http\Message\StreamFactory;

/**
 *  classTest\Http\Message\UploadedFileFactoryTest
 */
class UploadedFileFactoryTest extends TestCase
{
    /**
     * testCreateUploadedFile function
     *
     * @return void
     */
    public function testCreateUploadedFile()
    {
        $uploadedFilefactory = new UploadedFileFactory();
        $streamFactory = new StreamFactory();
        $stream =  $streamFactory->createStream();
        $uploadedFile =  $uploadedFilefactory->createUploadedFile($stream);
        $this->assertInstanceOf(UploadedFile::class, $uploadedFile);
    }
}
