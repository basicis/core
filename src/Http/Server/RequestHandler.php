<?php
namespace Basicis\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Basicis\Basicis as App;

/**
 * RequestHandler class
 * Handles a server request and produces a response.
 * An HTTP request handler process an HTTP request in order to produce an
 * HTTP response.
 *
 * @category Basicis/Http/Server
 * @package  Basicis/Http/Server
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Server/Middleware.php
 */
abstract class RequestHandler implements RequestHandlerInterface
{
     /**
    * Function handle
    * Handles a request and produces a response.
    * May call other collaborating code to generate the response.
    *
    * @param ServerRequestInterface $request
    * @param ResponseInterface $response
    * @param callable $next null
    * @return ResponseInterface
    */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ): ResponseInterface {
        return $this->handle(
            $request,
            $response,
            $next ?? function ($req, $res) {
                return $res;
            }
        );
    }

    /**
    * Function handle
    * Handles a request and produces a response.
    * May call other collaborating code to generate the response.
    *
    * @param ServerRequestInterface $request
    * @param ResponseInterface $response
    * @param callable $next null
    * @return ResponseInterface
    */
    abstract public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface;
}
