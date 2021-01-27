<?php
namespace Basicis\Http\Server;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Message\ResponseFactory;

/**
 * AuthInterface, all Auth classes implements from this
 *
 * @category Basicis/Auth
 * @package  Basicis/Auth
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Auth/AuthInterface.php
 */
interface MiddlewareInterface
{
  /**
     * Function process
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request $next handler to do so.
     *
     * ```php
     *  //Perform here all persoal code implementation and return $next
     *  retrun $next($request);
     * ```
     *
     * ```php
     *    //Or receive um ResponseInterface from $next and procces you ResponseInterface
     *    $response = $next($request);
     *    ...
     *    retrun $response;
     * ```
     *
     * @param ServerRequestInterface $request
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ): ResponseInterface;
}
