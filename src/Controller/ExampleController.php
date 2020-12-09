<?php
namespace Basicis\Controller;

use Basicis\Basicis as App;
use Basicis\Router\Route;

/**
 * ExampleController Class - Extends Controller and implements ControllerInterface,
 * all controller classes extend from this
 * @category Basicis/Controller
 * @package  Basicis/Controller
  * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Controller/ExampleController.php
 */
class ExampleController extends Controller
{
    /**
     * Function index
     *
     * @param App $app
     * @param object $args
     * @return void
     * @Route("/", "GET", "foo_create")
     */
    public function index($app, $args)
    {
        return $app->json(["test" => "Teste Ok!"], 201);
    }

}
