<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Basicis\Basicis as App;

/**
 * Class BasicisTest
 */

class BasicisTest extends TestCase
{
    /**
     * $app variable
     *
     * @var App
     */
    private $app;

    /**
     * $appArguments variable
     *
     * @var array
     */
    private $appArguments;

    public function __construct()
    {
        parent::__construct();

        $this->appArguments = [
            'uri' => '/',
            'method' =>'GET',
            'env' => [
                "APP_ENV" => "dev",
                "APP_TIMEZONE" =>  "America/Recife",
                "APP_PATH" => null
            ]
        ];
        
        //Create Basicis App
        $this->app = App::createApp();
    }

    /**
     * Function testConstruct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(App::Class, $this->app);
    }

    /**
     * Function testSetArgs
     *
     * @return void
     */
    public function testSetArgs()
    {
        //Setting App arguments
        $this->assertInstanceOf(App::Class, $this->app->setArgs($this->appArguments));
    }


    /**
     * Function testGetArgs
     *
     * @return void
     */
    public function testGetArgs()
    {
        //$>app->getArgs() retun an object, this is converted from an array
        $this->assertEquals($this->appArguments, (array) $this->app->getArgs());
    }

     /**
     * Function testGetEnv
     *
     * @return void
     */
    public function testGetEnv()
    {
        putenv('ENV_TEST=ok');
        $this->assertEquals("ok", App::getEnv("ENV_TEST"));
    }
    
}
