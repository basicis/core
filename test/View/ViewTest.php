<?php
namespace Test\View;

use PHPUnit\Framework\TestCase;
use Basicis\View\View;

/**
 * Class ViewTest
 */

class ViewTest extends TestCase
{
    /**
     * $app variable
     *
     * @var View
     */
    private static $view;

    public function testConstruct()
    {
        self::$view =  new View("./");
        $this->assertInstanceOf(View::Class, self::$view);
    }
}
