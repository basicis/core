<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Basicis\Console;

/**
 * Class ConsoleTest
 */
class ConsoleTest extends TestCase
{
    /**
     * $cli variable
     *
     * @var Console
     */
    private $cli;

    /**
     * $appArguments variable
     *
     * @var array
     */
    private $appArguments;

    public function __construct()
    {
        parent::__construct();
        $this->cli = new Console();
    }

    /**
     * Function testConstruct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Console::Class, $this->cli);
    }


    /**
     * Function testCommand
     *
     * @return void
     *//*
    public function testCommand()
    {
        //$this->assertInstanceOf(App::class, App::createapp());
    }
    */
}
