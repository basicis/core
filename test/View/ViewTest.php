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
    private $view;


    public function __construct()
    {
        parent::__construct();
        $this->view = new View("./");
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(View::Class, $this->view);
    }
}
