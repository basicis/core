<?php 
namespace Test\Core;
use PHPUnit\Framework\TestCase;
use Basicis\Basicis;
use Basicis\Core\Log;

/**
 * Class LogTest
 */

 class LogTest extends TestCase
 {  
    /**
     * log variable
     *
     * @var Log
     */
    private $log;
    /**
     * __construct function
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->log = new Log(Basicis::path(), null);
    }

     /**
     * testConstruct function
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Log::Class, $this->log);
    }


    /**
     * testInterpolate function
     *
     * @return void
     */
    public function testInterpolate()
    {
        $this->assertEquals('Menssagem Teste ok!' , $this->log->interpolate('Menssagem {test} ok!', ['test' => 'Teste']) );
    }

    /**
     * testFormatMessage function
     *
     * @return void
     */
    public function testFormatMessage()
    {
        $this->assertEquals(Date('Y/m/d').' | Menssagem!' , $this->log->formatMessage('debug', 'Menssagem!', 'Y/m/d') );
    }
    

    /**
     * testFormatMessageToArray function
     *
     * @return void
     */
    public function testFormatMessageToArray()
    {
        $this->assertEquals(
            [
                "date" => Date('Y/m/d'),
                "level" => ucfirst('debug'),
                "message" => 'Menssagem!',
                "context" => null
            ]
            , 
            $this->log->formatMessageToArray('debug', 'Menssagem!', 'Y/m/d') 
        );
    }




 }