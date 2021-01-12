<?php
namespace Basicis\Http\Server;

use Basicis\Basicis as App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
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
class Middleware extends RequestHandler implements MiddlewareInterface
{
    
    /**
     * $handlers
     *
     * @var array|RequestHandler[]
     */
    private $handlers;

    /**
     * $app variable
     *
     * @var App
     */
    protected $app;

    /**
     * Function __construct
     */
    public function __construct(App &$app, $handlers = null)
    {
        $this->app = $app;
        if (is_string($handlers)) {
            $this->handlers = $app->getMiddlewares($handlers);
        }

        if (is_array($handlers)) {
            $this->handlers = $handlers;
        }
    }

    /**
     * Function run
     * Run process han$handlers pool
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function run() : ResponseInterface
    {
        return $this->handle($this->app->getRequest());
    }

    /**
     * Function process
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
    }

    /**
    * Function handle
    * Handles a request and produces a response.
    * May call other collaborating code to generate the response.
    *
    * @param \Psr\Http\Message\ServerRequestInterface $request
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $response = $this->app->getResponse();
        foreach ($this->handlers as $next) {
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() <= 206) {
                $response = $this->process($request, new $next($this->app));
            }
        }
        return $this->app->getResponse()
        ->withStatus($response->getStatusCode(), $response->getReasonPhrase());
    }
}
