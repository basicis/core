<?php
namespace Basicis\Http\Server;

use Basicis\Basicis;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
     * $app variable
     *
     * @var Basicis
     */
    protected $app;

    /**
     * Function __construct
     * Receives an instance of Basicis \ Basicis or null as param
     * @param \Basicis\Basicis $app
     */
    public function __construct(Basicis $app = null)
    {
        if ($app instanceof Basicis) {
            $this->app = $app;
            return;
        }
        Basicis::loadEnv();
        $this->app = Basicis::createApp();
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
}
