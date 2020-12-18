<?php
namespace Basicis\Controller;

use \Psr\Http\Message\ServerRequestInterface;
use Basicis\Controller\ControllerInterface;
use Basicis\Basicis as App;

/**
 * Controller Class - Controller implements ControllerInterface,
 * all controller classes extend from this
 *
 * @category Basicis/Controller
 * @package  Basicis/Controller
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Controller/Controller.php
 */
abstract class Controller implements ControllerInterface
{
    /**
     * Abstract method, this must be implemented according to the ControllerInterface
     *
     * @return void
     */
    abstract public function index(App $app, object $args);
}
