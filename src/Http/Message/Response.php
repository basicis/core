<?php
namespace  Basicis\Http\Message;

use Psr\Http\Message\ResponseInterface;
use Basicis\Exceptions\InvalidArgumentException;

/**
 * Response class
 * Representation of an outgoing, server-side response.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - Status code and reason phrase
 * - Headers
 * - Message body
 *
 * Responses are considered immutable; all methods that might change state MUST
 * be implemented such that they retain the internal state of the current
 * message and return an instance that contains the changed state.
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/Response.php
 */
class Response extends Message implements ResponseInterface
{
    /**
     * $code variable
     * default: 200
     * @var int
     */
    private $code;

    /**
     * $reasonPhrase variable (Http status message)
     *
     * @var string
     */
    private $reasonPhrase;


    /**
     * An List of Representation of Http code status
     *
     *   CODE_LIST variable
     *
     *   - 10X | Information responses (100-101)
     *
     *   "100" => "Continue",
     *   "101" => "Switching Protocols",
     *
     *
     *   - 20X | Successful responses (200-206)
     *
     *   "200" => "OK",
     *   "201" => "Created",
     *   "202" => "Accepted",
     *   "203" => "Non-Authoritative Information",
     *   "204" => "No Content",
     *   "205" => "Reset Content",
     *   "206" => "Partial Content",
     *
     *   - 30X | Redirects (300-307)
     *
     *   "300" => "Multiple Choices",
     *   "301" => "Moved Permanently",
     *   "302" => "Found",
     *   "303" => "See Other",
     *   "304" => "Not Modified",
     *   "305" => "Use Proxy",
     *   "307" => "Temporary Redirect",
     *
     *   - 40X Client errors (400-417)
     *
     *   "400" => "Bad Request",
     *   "401" => "Unauthorized",
     *   "402" => "Payment Required",
     *   "403" => "Forbidden",
     *   "404" => "Not Found",
     *   "405" => "Method Not Allowed",
     *   "406" => "Not Acceptable",
     *   "407" => "Proxy",
     *   "408" => "Request Timeout",
     *   "409" => "Conflict",
     *   "410" => "Gone",
     *   "411" => "Length Required",
     *   "412" => "Precondition Failed",
     *   "413" => "Request Entity Too Large",
     *   "414" => "Request-URI Too Large",
     *   "415" => "Unsupported Media Type",
     *   "416" => "Requested Range Not Satisfiable",
     *   "417" => "Expectation Failed",
     *
     *   - 50X | Server errors (500-505)
     *
     *   "500" => "Internal Server Error",
     *   "501" => "Not Implemented",
     *   "502" => "Bad Gateway",
     *   "503" => "Service Unavailable",
     *   "504" => "Gateway Timeout",
     *   "505" => "HTTP Version not supported"
     *
     * @var array
     */
    const CODE_LIST = [
        //10X
        "100" => "Continue",
        "101" => "Switching Protocols",
        //20X
        "200" => "OK",
        "201" => "Created",
        "202" => "Accepted",
        "203" => "Non-Authoritative Information",
        "204" => "No Content",
        "205" => "Reset Content",
        "206" => "Partial Content",
        //30X
        "300" => "Multiple Choices",
        "301" => "Moved Permanently",
        "302" => "Found",
        "303" => "See Other",
        "304" => "Not Modified",
        "305" => "Use Proxy",
        "307" => "Temporary Redirect",
        //40X
        "400" => "Bad Request",
        "401" => "Unauthorized",
        "402" => "Payment Required",
        "403" => "Forbidden",
        "404" => "Not Found",
        "405" => "Method Not Allowed",
        "406" => "Not Acceptable",
        "407" => "Proxy",
        "408" => "Request Timeout",
        "409" => "Conflict",
        "410" => "Gone",
        "411" => "Length Required",
        "412" => "Precondition Failed",
        "413" => "Request Entity Too Large",
        "414" => "Request-URI Too Large",
        "415" => "Unsupported Media Type",
        "416" => "Requested Range Not Satisfiable",
        "417" => "Expectation Failed",
        //50X
        "500" => "Internal Server Error",
        "501" => "Not Implemented",
        "502" => "Bad Gateway",
        "503" => "Service Unavailable",
        "504" => "Gateway Timeout",
        "505" => "HTTP Version not supported"
    ];

    /**
     * Function ___contruct
     *
     * @param int $code default 200
     * @param string $reasonPhrase
     *
     * @return void
     */
    public function __construct(int $code = 200, string $reasonPhrase = null)
    {
        return $this->withStatus($code, $reasonPhrase);
    }


    /**
     * Function getStatusCode
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function getStatusCode(): int
    {
        return $this->code ;
    }

    /**
     * Function withStatus
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * If no reason phrase is specified, implementations MAY choose to default
     * to the RFC 7231 or IANA recommended reason phrase for the response's
     * status code.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated status and reason phrase.
     *
     * @link http://tools.ietf.org/html/rfc7231#section-6
     * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @param int $code The 3-digit integer result code to set.
     * @param string $reasonPhrase The reason phrase to use with the
     *     provided status code; if none is provided, implementations MAY
     *     use the defaults as suggested in the HTTP specification.
     * @return static
     * @throws InvalidArgumentException For invalid status code arguments.
     */
    public function withStatus($code, $reasonPhrase = null) : Response
    {
        if (((isset($code) && is_int($code)) && array_key_exists($code, self::CODE_LIST))) {
            $this->code = $code;
            if (is_null($reasonPhrase) | $reasonPhrase === '') {
                $this->reasonPhrase = Response::CODE_LIST[$code];
            } else {
                $this->reasonPhrase = $reasonPhrase;
            }
        } else {
            throw new InvalidArgumentException("Invalid Http status code $code argument inputed.");
        }
        return $this;
    }

    /**
     * Function getReasonPhrase
     * Gets the response reason phrase associated with the status code.
     *
     * Because a reason phrase is not a required element in a response
     * status line, the reason phrase value MAY be null. Implementations MAY
     * choose to return the default RFC 7231 recommended reason phrase (or those
     * listed in the IANA HTTP Status Code Registry) for the response's
     * status code.
     *
     * @link http://tools.ietf.org/html/rfc7231#section-6
     * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @return string Reason phrase; must return an empty string if none present.
     */
    public function getReasonPhrase() : string
    {
        return  $this->reasonPhrase ?? Response::CODE_LIST[$this->getStatusCode()];
    }
}
