<?php
namespace Basicis\Http\Client;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Message\Response;
use Basicis\Http\Message\Request;
use Basicis\Http\Message\Stream;

/**
 * Client class
 * @category Basicis/Http/Client
 * @package  Basicis/Http/Client
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Client/Client.php
 */
class Client implements ClientInterface
{
    /**
     * $data variable
     *
     * @var array
     */
    private $data;

    /**
     * $content variable
     *
     * @var array
     */
    private $context;

    /**
     * $request variable
     *
     * @var RequestInterface
     */
    private $request;

    /**
     * Funtion sendRequest
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ClientException If an error happens while processing the request.
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $response = new Response();
        $resource = @fopen($request->getUri()->__toString(), 'r', false, $this->createContext($request));

        if (isset($http_response_header)) {
            $response->parseHeaders($http_response_header);
        }
            
        if (is_resource($resource) && isset($http_response_header)) {
            $response->withBody(new Stream($resource, ['mode' => 'r+']));
        } elseif (!is_resource($resource) && !isset($http_response_header)) {
            if ($response->getStatusCode() === 200 | !isset($http_response_header)) {
                $response->withStatus(504); // "504" => "Gateway Timeout"
            }

            throw new ClientException(
                "An error occurred while connecting to the remote stream {$request->getUri()->__toString()} .",
                0,
                __FILE__
            );
        }
        return $response;
    }

    /**
     * Function createContext
     * Creates an http | https context with the stream_context_create() function
     *  and returns the resource
     *
     * @param RequestInterface $request
     * @param array $content
     * @return resource
     */
    private function createContext(RequestInterface $request)
    {
        $headers = array_merge(
            $request->getHeaderLines(),
            [
                'User-Agent: Basicis/Http/Client',
                //'Connection: keep-alive',
            ]
        );
        $options = array (
            'http' => [
                'ignore_errors' => true,
                'max_redirects' => 20,
                'protocol_version' => (float) $request->getProtocolVersion(),
                'method' => $request->getMethod(),
                'header' => $headers ,
                'content' => http_build_query($request->getContentData()),
            ]
        );
        return stream_context_create($options);
    }

    /**
     * Function getMethod
     *
     * Instance a Request Interface object with the specified $ method,
     * $uri, $data, and $options, and returns the created instance.
     *
     * @param string $method
     * @param string $uri
     * @param array $data [,$options = []]
     * @return RequestInterface
     */
    private function getMethod(string $uri, string $method = 'GET', array ...$options) : RequestInterface
    {
        return new Request($uri, $method, $options);
    }

    /**
     * Function get
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function get(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'GET', $options));
    }

    /**
     * Function post
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function post(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'POST', $options));
    }

    /**
     * Function path
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function path(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'PATH', $options));
    }

    /**
     * Function put
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function put(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'PUT', $options));
    }

    /**
     * Function delete
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function delete(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'DELETE', $options));
    }

    /**
     * Function options
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function options(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'OPTIONS', $options));
    }

    /**
     * Function head
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function head(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'HEAD', $options));
    }

     /**
     * Function purge
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function purge(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'PURGE', $options));
    }

     /**
     * Function trace
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function trace(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'TRACE', $options));
    }

    /**
     * Function connect
     *
     * Instance a Request Interface object with the specified $method, $uri, $data, and $options,
     * and returns a ResponseInterface instance.
     *
     * @param string $uri
     * @param array $data [,$options = []]
     * @return ResponseInterface
     */
    public function connect(string $uri, array ...$options) : ResponseInterface
    {
        return $this->sendRequest($this->getMethod($uri, 'CONNECT', $options));
    }
}
