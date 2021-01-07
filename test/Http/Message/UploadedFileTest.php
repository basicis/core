<?php
namespace Test\Message\Http;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Message\UploadedFile;
use Basicis\Http\Message\Stream;
use Basicis\Http\Message\StreamFactory;

/**
 *  classTest\Http\Message\UploadedFileTest
 */
class UploadedFileTest extends TestCase
{
    private $uploadedFile;

    public function __construct()
    {
        parent::__construct();
        $this->uploadedFile = new UploadedFile((new StreamFactory)->createStream());
    }

    /**
     * testGetStream function
     *
     * @return void
     */
    public function testGetStream()
    {
        $this->assertInstanceof(Stream::class, $this->uploadedFile->getStream());
    }

    /**
     * testMoveTo function
     *
     * @return void
     */
    public function testMoveTo()
    {
        $path = 'php://temp/test';
        $this->uploadedFile->moveTo($path);
        $this->assertEquals(false, file_exists($path));
    }
    
    /**
     * testGetSize function
     *
     * @return void
     */
    public function testGetSize()
    {
        $this->assertEquals(null, $this->uploadedFile->getSize());
    }
    
    /**
     * testGetError function
     *
     * @return void
     */
    public function testGetError()
    {
        $this->assertEquals(0, $this->uploadedFile->getError());
    }
    
    /**
     * testGetClientFilename function
     *
     * @return void
     */
    public function testGetClientFilename()
    {
        $this->assertNotEmpty($this->uploadedFile->getClientFilename());
    }
    
    /**
     * testGetClientMediaType function
     *
     * @return void
     */
    public function testGetClientMediaType()
    {
        $this->assertEquals(null, $this->uploadedFile->getClientMediaType());
    }
}
