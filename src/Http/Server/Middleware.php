<?php
namespace Basicis\Http\Server;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Message\ResponseFactory;

/**
 * Middleware class
 * Participant in processing a server request and response.
 *
 * An HTTP middleware component participates in processing an HTTP message:
 * by acting on the request, generating the response, or forwarding the
 * request to a subsequent middleware and possibly acting on its response.
 *
 * @category Basicis/Http/Server
 * @package  Basicis/Http/Server
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Server/Middleware.php
 */
abstract class Middleware implements MiddlewareInterface
{
    /**
     * Function process
     * Process an incoming server request a alias to process method
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param MiddlewareInterface|null $next
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ): ResponseInterface {
        return $this->process(
            $request,
            $response,
            $next ?? function ($req, $res) {
                return $res;
            }
        );
    }

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
     * @param ResponseInterface $response
     * @param callable|null $next
     *
     * @return ResponseInterface
     */
    abstract public function process(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ): ResponseInterface;

    /**
     * Funtion setPipeLine
     * Handle all middlewares
     *
     * @param array $middlewares
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return PipeLine
     */
    public static function pipeLine(array $middlewares) : PipeLine
    {
        //Handle all middlewares
        $pipeLine = new PipeLine();
        foreach ($middlewares as $middleware) {
            $pipeLine->add($middleware);
        }
        return $pipeLine;
    }
}
