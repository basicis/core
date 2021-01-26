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

    /**
     * Function createFromArray
     * Create a instance of ServerRequestInterface object
     * @param array $params
     *
     * @return ServerRequestInterface
     */
    public static function createFromArray(array $params = []) : ServerRequestInterface
    {
        $serverParams = self::extractServerParams($params);
        $requestParams = self::extractRequestParams($params);

        $serverParams["cache"] = $params["cache"] ?? false;
        $serverParams["files"] = $params["files"] ?? [];
        $serverParams["cookie"] = $params["cookie"] ?? [];
        $serverParams["headers"] = self::extractHeadersParams($params);
        $serverParams["headers"] = self::extractRemoteParams($params);
        
        $request = (new ServerRequest(
            (new Uri())
            ->withHost($requestParams["host"] ?? "localhost")
            ->withPort($serverParams["port"] ?? null)
            ->withPath($requestParams["uri"]),
            $requestParams["method"] ?? "GET",
            $serverParams
        ));

        foreach (self::extractAppParams($params) as $name => $value) {
            $request->withAttribute("app".ucfirst($name), $value);
        }

        foreach (self::extractDBParams($params) as $name => $value) {
            $request->withAttribute("db".ucfirst($name), $value);
        }

        $defaultToken =  [
            "iss" => $request->getAttribute("appDescription", ""),
            "expiration" => "+30 minutes",
            "nobefore" => "now",
        ];

        if (isset($params["token"])) {
            $defaultToken = array_merge($params["token"], $defaultToken);
        }

        foreach ($defaultToken as $name => $value) {
            $request->withAttribute("token".ucfirst($name), $value);
        }
        return $request;
    }

    /**
     * Function extractParams
     * Extract Params from array and replace keys starts
     * @param array $params
     * @param array $replace
     *
     * @return array
     */
    private static function extractParams(array &$params = [], $replace = []) : array
    {
        $returnParams = [];
        foreach ($params as $name => $value) {
            $name = strtolower($name);
            if (is_array($value)) {
                foreach ($value as $vk => $vv) {
                    foreach ($replace as $rk => $rvalue) {
                        if (str_starts_with($vk, $rvalue)) {
                            $returnParams[strtolower(str_replace($replace, "", $vk))] = $vv;
                            unset($params[$name][$vk]);
                        }
                    }
                }
            }
            if (!is_array($value)) {
                foreach ($replace as $rk => $rvalue) {
                    if (str_starts_with($vk, $rvalue)) {
                        $returnParams[strtolower(str_replace($replace, "", $name))] = $value;
                        unset($params[$name]);
                    }
                }
            }
        }
        return  $returnParams;
    }

    /**
     * Function extractServerParams
     * Extract server params and return a array
     * @param array $params
     *
     * @return array
     */
    private static function extractServerParams(array &$params = []) : array
    {
        return self::extractParams($params, ["SERVER_", "DOCUMENT_", "SCRIPT_", "PHP_"]);
    }

    /**
     * Function extractServerParams
     * Extract server params and return a array
     * @param array $params
     *
     * @return array
     */
    private static function extractRequestParams(array &$params = []) : array
    {
        return self::extractParams($params, ["REQUEST_"]);
    }

    /**
     * Function extractRemoteParams
     * Extract remote params and return a array
     * @param array $params
     *
     * @return array
     */
    private static function extractRemoteParams(array &$params = []) : array
    {
        return self::extractParams($params, ["REMOTE_"]);
    }

    /**
     * Function extractHeadersParams
     * Extract Headers params and return a array
     * @param array $params
     *
     * @return array
     */
    private static function extractHeadersParams(array &$params = []) : array
    {
        return self::extractParams($params, ["HTTP_"]);
    }

    /**
     * Function extractAppParams
     * Extract app params and return a array
     * @param array $params
     *
     * @return array
     */
    private static function extractAppParams(array &$params = []) : array
    {
        return self::extractParams($params, ["APP_"]);
    }

    /**
     * Function extractDBParams
     * Extract database params and return a array
     * @param array $params
     *
     * @return array
     */
    private static function extractDBParams(array &$params = []) : array
    {
        return self::extractParams($params, ["DB_", "DATABASE_"]);
    }
}
