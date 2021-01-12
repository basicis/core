<?php
namespace Basicis\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
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
class RequestHandler implements RequestHandlerInterface
{
    /**
     * $app variable
     *
     * @var App
     */
    protected $app;

    /**
     * Function __construct
     * Receives a instance of Basicis\Basicis $app as argument
     * @param \Basicis\Basicis $app
     */
    public function __construct(App &$app)
    {
        $this->app = $app;
    }

   /**
    * Function handle
    * Handles a request and produces a response.
    * May call other collaborating code to generate the response.
    *
    * @param \Psr\Http\Message\ServerRequestInterface $request
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->app->getResponse();
    }
}
