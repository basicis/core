<?php
namespace Basicis\Http\Server;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Message\ResponseFactory;
use Basicis\Http\Server\Middleware;

/**
 *  ExampleMiddleware Class
 */
class ExampleMiddleware extends Middleware
{
     /**
     * Function process
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request next handler to do so.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ): ResponseInterface {
        /**
         *
         * Proccess here
         * All persoal middleware code implementation
         *
         */
        if ($next === null) {
            return $response;
        }
        return $next($request, $response);
    }
}
