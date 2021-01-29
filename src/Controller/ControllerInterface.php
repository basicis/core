<?php
namespace Basicis\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Server\RequestHandlerInterface;
use Basicis\Model\Model;
use Basicis\Model\Models;
use Basicis\Basicis as App;

/**
 * ControllerInterface, all controller classes implements from this
 * @category Basicis/Controller
 * @package  Basicis/Controller
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Controller/ControllerInterface.php
 */
interface ControllerInterface extends RequestHandlerInterface
{
     /**
      * Function handle
      * Default method
      *
      * @param ServerRequestInterface $request
      * @param ResponseInterface $response
      * @param callable $next
      * @param object|array|null $args
      *
      * @return ResponseInterface
      */
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface;

    /**
    * Function index
    * Default method index
    * @param \Basicis\Basicis $app
    * @param object $args
    *
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function index(App $app, object $args = null) : ResponseInterface;

    /**
     * Function create
     * Creates a model of the specified class
     * @param \Basicis\Basicis $app
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(App $app, object $args = null) : ResponseInterface;

    /**
     * Function update
     * Update a model of the specified class
     * @param \Basicis\Basicis $app
     * @param \Basicis\Model\Model $model
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(App $app, object $args = null) : ResponseInterface;

    /**
     * Function delete
     * Delete a model of the specified class
     * @param \Basicis\Basicis $app
     * @param \Basicis\Model\Model $model
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(App $app, object $args = null) : ResponseInterface;

    /**
     * Function find
     * Find one a model item of the specified class
     * @param \Basicis\Basicis $app
     * @param \Basicis\Model\Model $model
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function find(App $app, object $args = null) : ResponseInterface;

    /**
     * Function all
     * Find all a model items of the specified class
     * @param \Basicis\Basicis $app
     * @param Models $models
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function all(App $app, object $args = null) : ResponseInterface;
}
