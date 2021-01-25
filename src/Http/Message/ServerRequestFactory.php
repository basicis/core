<?php
namespace  Basicis\Http\Message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

/**
 * ServerRequestFactory class
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/ServerRequestFactory.php
 */
class ServerRequestFactory implements ServerRequestFactoryInterface
{
    /**
     * Function createServerRequest
     * Create a new server request.
     * Note that server-params are taken precisely as given - no parsing/processing
     * of the given values is performed, and, in particular, no attempt is made to
     * determine the HTTP method or URI, which must be provided explicitly.
     *
     * @param string $method The HTTP method associated with the request.
     * @param UriInterface|string $uri The URI associated with the request. If
     *     the value is a string, the factory MUST create a UriInterface
     *     instance based on it.
     * @param array $serverParams Array of SAPI parameters with which to seed
     *     the generated request instance.
     *
     * @return ServerRequestInterface
     */
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return new ServerRequest($uri, $method, $serverParams);
    }

     /**
     * Function create
     * Create a new server request.
     * Note that server-params are taken precisely as given - no parsing/processing
     * of the given values is performed, and, in particular, no attempt is made to
     * determine the HTTP method or URI, which must be provided explicitly.
     *
     * @param string $method The HTTP method associated with the request.
     * @param UriInterface|string $uri The URI associated with the request. If
     *     the value is a string, the factory MUST create a UriInterface
     *     instance based on it.
     * @param array $serverParams Array of SAPI parameters with which to seed
     *     the generated request instance.
     *
     * @return ServerRequestInterface
     */
    public static function create(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $uri, $serverParams);
    }


    public function createFromGlobals(array $globals = [], array $serverParams = []) : ServerRequestInterface
    {
        $options = [
            "server" => [
                "REQUEST_METHOD" => "GET",
                "SERVER_PROTOCOL" => "http",
                "HTTP_HOST" => "0.0.0.0",
                "REQUEST_URI" => "/",
                "SERVER_PORT" => null
            ],
            "files" => [],
            "cookie" => [],
            "env" => []
        ];

        foreach ($globals as $global => $value) {
            if (key_exists($global, $options)) {
                $options[$global] = array_merge($options[$global], $value);
            }
        }
        
        //Creating ServerRequest and Uri into this
        return self::create(
            $options["server"]["REQUEST_METHOD"],
            (new Uri())
            ->withScheme(explode("/", $options["server"]["SERVER_PROTOCOL"])[0] ?? "http")
            ->withHost($options["server"]["HTTP_HOST"] ?? "localhost")
            ->withPort($options["server"]["SERVER_PORT"] ?? null)
            ->withPath($options["server"]["REQUEST_URI"]),
            $serverParams
        )
        ->withHeaders(getallheaders())
        ->withUploadedFiles($options["files"])
        ->withCookieParams($_COOKIE);
    }


    public function filterSeverParams(array $serverParams = []) : array
    {
        foreach ($serverParams as $key => $param) {
            var_dump($param, $key);
        }
    }
}
