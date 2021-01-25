<?php
namespace Basicis\Http\Server;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface as PsrMiddleware;
use Basicis\Http\Message\ResponseFactory;

/**
 * RequestHandlerInterface, all RequestHandler classes implements from this
 *
 * @category Basicis
 * @package  Basicis
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Server/RequestHandlerInterface.php
 */
interface RequestHandlerInterface
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
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface;
}
