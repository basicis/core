<?php
namespace Basicis\Controller;

use Basicis\Basicis as App;

/**
 * ControllerInterface, all controller classes implements from this
 *
 * @category Basicis/Controller
 * @package  Basicis/Controller
  * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Controller/ControllerInterface.php
 */
interface ControllerInterface
{
    /**
     * All controller classes must implement
     * @return void
     */
    public function index(App $app, object $args);
}
