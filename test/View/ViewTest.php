<?php
namespace Test\View;

use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;
use Basicis\View\View;
use Basicis\Exceptions\InvalidArgumentException;
use Basicis\Basicis as App;

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
    private $view;

    /**
     * Function __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->view = new View([App::path()."storage/templates/"]);
    }

    /**
     * Function testConstruct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(View::Class, $this->view);
    }

    /**
     * Function testGetView
     *
     * @return void
     */
    public function testGetView()
    {
        $this->assertEquals("Test Ok!", $this->view->getView("test", ["testMsg" => "Test Ok!"]));
    }

    /**
     * Function testSetFilters
     * @return void
     */
    public function testSetFilters()
    {
       
        $this->view->setFilters(
            [
                "test" => new TwigFunction("test", function () {
                    return true;
                })
            ]
        );
        $this->assertinstanceOf(View::Class, $this->view);
        $this->assertEquals(true, $this->view->hasFunction("test"));

        $this->expectException(InvalidArgumentException::class);
        $this->view->setFilters(
            [
                "test2" => function () {
                    return true;
                }
            ]
        );
        $this->assertinstanceOf(View::Class, $this->view);
        $this->assertEquals(false, $this->view->hasFunction("test2"));
    }
}
