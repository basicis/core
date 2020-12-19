<?php
namespace Basicis\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * RequestFactory class
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/RequestFactory.php
 */
class RequestFactory implements RequestFactoryInterface
{
    /**
     * Funtion createRequest
     * Create a new request.
     *
     * @param string              $method The HTTP method associated with the request.
     * @param UriInterface|string $uri    The URI associated with the request. If
     *                                    the value is a string, the factory MUST
     *                                    create a UriInterface instance based on
     *                                    it.
     *
     * @return RequestInterface
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        return new Request($uri, $method);
    }

    /**
     * Funtion static createRequest
     * Create a new request.
     *
     * @param string              $method The HTTP method associated with the request.
     * @param UriInterface|string $uri    The URI associated with the request. If
     *                                    the value is a string, the factory MUST
     *                                    create a UriInterface instance based on
     *                                    it.            
     *
     * @return RequestInterface
     */
    public static function create(string $method, $uri) : RequestInterface
    {
        $factory = new self();
        return $factory->createRequest($uri, $method);
    }
}
