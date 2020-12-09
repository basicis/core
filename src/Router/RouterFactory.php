<?php
namespace Basicis\Router;

use Psr\Http\Message\ServerRequestInterface;

/**
 * RouteFactory Class
 * An Factory from Basicis\Router\Router
 *
 * @category Basicis/Router
 * @package  Basicis/Router
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Router/RouterFactory.php
 */
class RouterFactory
{
    /**
     * Function create
     * Create an instance of  Basicis\Router\Router
     *
     * @param string $filesPath
     * @param ServerRequestInterface $request
     * @return Router
     */
    public static function create(ServerRequestInterface $request) : Router
    {
        //Starting Router Pool, Loading files and get Route Object
        return new Router($request);
    }
}
