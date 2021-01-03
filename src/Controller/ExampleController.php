<?php
namespace Basicis\Controller;

use Psr\Http\Message\ResponseInterface;
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
 * @Model App\Models\Example
 * @IgnoreAnnotation("Model")
 */
class ExampleController extends Controller
{
    /**
     * Function index
     * @param      App    $app
     * @param      object $args
     * @return     void
     * @Route("/", "GET", "guest")
     */
    public function index(App $app, object $args = null) : ResponseInterface
    {
        return $app->json(["test" => "Teste Ok!"], 200);
    }
}
