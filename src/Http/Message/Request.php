<?php
namespace  Basicis\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Basicis\Exceptions\InvalidArgumentException;

/**
 * Request class
 * Representation of an outgoing, client-side request.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - HTTP method
 * - URI
 * - Headers
 * - Message body
 *
 * During construction, implementations MUST attempt to set the Host header from
 * a provided URI if no Host header is provided.
 * Requests are considered immutable; all methods that might change state MUST
 * be implemented such that they retain the internal state of the current
 * message and return an instance that contains the changed state.
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/Request.php
 */
class Request extends Message implements RequestInterface
{
    /**
     * $target variable
     *
     * @var string
     */
    protected $target;

    /**
     * $uri variable
     *
     * @var UriInterface
     */
    protected $uri;

    /**
     * $method variable
     *
     * @var string
     */
    protected $method;
    
    /**
     * VALID_METHODS constant
     *
     * @var const
     */
    const VALID_METHODS = [
        'HEAD',
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
        'PURGE',
        'OPTIONS',
        'TRACE',
        'CONNECT'
    ];

    /**
     * Function __construct
     *
     * @param string $target = null
     * @param string $method = 'GET' for Dafault
     * @param array  $data   [,$options = []]
     */
    public function __construct(string $target = '/', string $method = 'GET', array ...$options)
    {
        $this->withMethod($method);
        $this->withUri(new Uri($target));

        foreach ($options as $key => $value) {
            if (strtolower($key) === 'version') {
                $this->withProtocolVersion($value);
            }

            if (srtolower($key) === 'headers') {
                $this->withHeaders($value);
            }
        }
    }

    /**
     * Function getRequestTarget
     * Retrieves the message's request-target either as it will appear
     *
     * (forclients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI,
     * unless a value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * If no URI is available, and no request-target has been specifically
     * provided, this method MUST return the string "/".
     *
     * @return string
     */
    public function getRequestTarget() : string
    {
        return $this->uri ? $this->extractTarget($this->uri->__toString()) : '/';
    }


    /**
     * Function withRequestTarget
     * Return an instance with the specific request-target.
     *
     * If the request needs a non-origin-form request-target — e.g., for
     * specifying an absolute-form, authority-form, or asterisk-form —
     * this method may be used to create an instance with the specified
     * request-target, verbatim.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @link   http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
     *     request-target forms allowed in request messages)
     * @param  mixed $requestTarget
     * @return static
     */
    public function withRequestTarget($requestTarget) : Request
    {
        $this->uri = new Uri($requestTarget);
        return $this;
    }

    /**
     * Function getMethod
     * Retrieves the HTTP method of the request.
     *
     * @return string Returns the request method.
     */
    public function getMethod() : string
    {
        return $this->method ?? 'GET';
    }

    /**
     * Function withMethod
     * Return an instance with the provided HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request method.
     *
     * @param  string $method Case-sensitive method.
     * @return static
     * @throws InvalidArgumentException for invalid HTTP methods.
     */
    public function withMethod($method) : Request
    {
        if (!in_array(strtoupper($method), self::VALID_METHODS)) {
            throw new InvalidArgumentException("Invalid or unsupported Method.");
        }
        $this->method = strtoupper($method);
        return $this;
    }

    /**
     * Function getUri
     * Retrieves the URI instance.
     *
     * This method MUST return a UriInterface instance.
     *
     * @link   http://tools.ietf.org/html/rfc3986#section-4.3
     * @return UriInterface Returns a UriInterface instance
     *     representing the URI of the request.
     */
    public function getUri() : Uri
    {
        return $this->uri ?? new Uri($this->target);
    }

    /**
     * Function withUri
     * Returns an instance with the provided URI.
     *
     * This method MUST update the Host header of the returned request by
     * default if the URI contains a host component. If the URI does not
     * contain a host component, any pre-existing Host header MUST be carried
     * over to the returned request.
     * You can opt-in to preserving the original state of the Host header by
     * setting `$preserveHost` to `true`. When `$preserveHost` is set to
     * `true`, this method interacts with the Host header in the following ways:
     *
     * - If the Host header is missing or empty, and the new URI contains
     *   a host component, this method MUST update the Host header in the returned
     *   request.
     * - If the Host header is missing or empty, and the new URI does not contain a
     *   host component, this method MUST NOT update the Host header in the returned
     *   request.
     * - If a Host header is present and non-empty, this method MUST NOT update
     *   the Host header in the returned request.
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new UriInterface instance.
     *
     * @link   http://tools.ietf.org/html/rfc3986#section-4.3
     * @param  UriInterface $uri          New request URI to use.
     * @param  bool         $preserveHost Preserve the original state of the Host header.
     * @return static
     */

    public function withUri(UriInterface $uri, $preserveHost = false) : Request
    {
        if ($uri != $this->uri) {
            $this->uri = $uri;
        }
        return $this;
    }


    /**
     * Function getContentData
     *
     * @return array
     */
    public function getContentData() : array
    {
        return $this->contentData ?? [];
    }


    /**
     * Function withContentData
     *
     * @param  array $data
     * @return Request
     * @throws InvalidArgumentException
     */
    public function withContentData(array $data = []) : Request
    {
        foreach ($data as $key => $value) {
            if (preg_match('/^[a-zA-Z0-9]{3,}$/', $key)) {
                $this->contentData[$key] = $value;
                return $this->withHeader('content-length', strlen(json_encode($data)));
            }
        }
        return $this;
    }

    /**
     * Function extractTarget
     *
     * @param string $target
     *
     * @return string
     */
    private function extractTarget(string $target) : string
    {
        $url = explode("://" . $this->getUri()->getHost(), $target);
        if (count($url) === 2) {
            return $url[1];
        }
        return $url[0];
    }
}
