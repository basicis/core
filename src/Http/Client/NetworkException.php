<?php
namespace Basicis\Http\Client;

use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Basicis\Http\Message\Request;

/**
 * NetworkException class
 * Thrown when the request cannot be completed because of network issues.
 * There is no response object as this exception is thrown when no response has been received.
 * Ex: the target host name can not be resolved or the connection failed.
 * @category Basicis/Http/Client
 * @package  Basicis/Http/Client
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Client/NetworkException.php
 */
class NetworkException extends ClientException implements NetworkExceptionInterface
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
