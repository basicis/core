<?php
namespace Basicis\Http\Client;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Basicis\Http\Message\Request;

/**
 * RequestException class
 * Exception for when a request failed.
 *
 * Ex:
 *      - Request is invalid (e.g. method is missing)
 *      - Runtime request errors (e.g. the body stream is not seekable)
 *
 * @category Basicis/Http/Client
 * @package  Basicis/Http/Client
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Client/RequestException.php
 */
class RequestException extends ClientException implements RequestExceptionInterface
{
    /**
     * Function getRequest
     * Returns the request.
     * The request object MAY be a different object from the one passed to ClientInterface::sendRequest()
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request ?? new Request();
    }
}
