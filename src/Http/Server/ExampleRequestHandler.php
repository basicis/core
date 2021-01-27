<?php
namespace Basicis\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Basicis\Http\Server\Middleware;

/**
 *  ExampleRequestHandler Class
 */
class ExampleRequestHandler extends RequestHandler
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
