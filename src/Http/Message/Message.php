<?php
namespace Basicis\Http\Message;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;
use Basicis\Exceptions\InvalidArgumentException;

/**
 * Message class
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/Message.php
 */

class Message implements MessageInterface
{

    /**
     * $version variable
     *
     * @var string
     */
    protected $version;

    /**
     * $body variable
     *
     * @var Stream
     */
    protected $body;

    /**
     * $headers variable
     *
     * @var array
     */
    protected $headers = [];

    /**
     * $suported_versions variable
     *
     * @var array
     */
    protected $suported_versions = ["1.0", "1.1"];

    /**
     * Function normalizeHeaderKey
     *
     * @param string $key
     * @return string
     */
    public function normalizeHeaderKey(string $key) : string
    {
        return str_replace(' ', '-', ucwords(str_replace(['_', '-'], ' ', $key)));
    }

    /**
     * Function getProtocolVersion
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.0", "1.1").
     *
     * @return string HTTP protocol version.
     */
    public function getProtocolVersion() : string
    {
        return $this->version ?? '1.1';
    }


    /**
     * Function withProtocolVersion
     * Return an instance with the specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new protocol version.
     *
     * @param string $version HTTP protocol version
     * @return static
     * @throws InvalidArgumentExcepition
     */
    public function withProtocolVersion($version) : Message
    {
        if (in_array($version, $this->suported_versions)) {
            $this->version = (string) $version;
        } else {
            throw new InvalidArgumentExcepition("Unsupported Version. Try '1.0' or '1.1'.");
        }
        return $this;
    }


    /**
     * Funtion getHeaders
     * Retrieves all message header values
     *
     * The keys represent the header name as it will be sent over the wire, and
     * each value is an array of strings associated with the header.
     *
     *     // Represent the headers as a string
     *     foreach ($message->getHeaders() as $name => $values) {
     *         echo $name . ": " . implode(", ", $values);
     *     }
     *
     *     // Emit headers iteratively:
     *     foreach ($message->getHeaders() as $name => $values) {
     *         foreach ($values as $value) {
     *             header(sprintf('%s: %s', $name, $value), false);
     *         }
     *     }
     *
     * While header names are not case-sensitive, getHeaders() will preserve the
     * exact case in which headers were originally specified.
     *
     * @return string[][] Returns an associative array of the message's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings
     *     for that header.
     */
    public function getHeaders() : array
    {
        return  $this->headers;
    }


    /**
    * Function hasHeader
    * Checks if a header exists by the given case-insensitive name.
    *
    * @param string $name Case-insensitive header field name.
    * @return bool Returns true if any header names match the given header
    *     name using a case-insensitive string comparison. Returns false if
    *     no matching header name is found in the message.
    */
    public function hasHeader($name) : bool
    {
        return in_array($name, $this->headers);
    }


    /**
    * Function getHeader
    * Retrieves a message header value by the given case-insensitive name.
    *
    * This method returns an array of all the header values of the given
    * case-insensitive header name.
    * If the header does not appear in the message, this method MUST return an
    * empty array.
    *
    * @param string $name Case-insensitive header field name.
    * @return array|string[] An array of string values as provided for the given
    *    header. If the header does not appear in the message, this method MUST
    *    return an empty array.
    */
    public function getHeader($name) : array
    {
        return  $this->headers[$name] ?? [];
    }


    /**
    * Function getHeaderLine
    *
    * Retrieves a comma-separated string of the values for a single header.
    *
    * This method returns all of the header values of the given
    * case-insensitive header name as a string concatenated together using
    * a comma.
    * NOTE: Not all header values may be appropriately represented using
    * comma concatenation. For such headers, use getHeader() instead
    * and supply your own delimiter when concatenating.
    * If the header does not appear in the message, this method MUST return
    * an empty string.
    *
    * @param string $name Case-insensitive header field name.
    * @return string A string of values as provided for the given header
    *    concatenated together using a comma. If the header does not appear in
    *    the message, this method MUST return an empty string.
    */
    public function getHeaderLine($name) : string
    {
        if (count($this->getHeader($name)) >= 1) {
            return $this->normalizeHeaderKey($name).": ". implode('; ', $this->getHeader($name)) ;
        }
        return '';
    }
    
    /**
     * Function getHeaderLines
     *
     * Retrieves all message header lines values in one array of string
     *
     * @return array|string[]
     */
    public function getHeaderLines() : array
    {
        $lines = [];
        foreach ($this->getHeaders() as $name => $value) {
            if (count($this->getHeader($name)) >= 1) {
                $lines[] = $this->normalizeHeaderKey($name).":". implode(';', $this->getHeader($name)) ;
            }
        }
        return $lines;
    }


    /**
     * Function withHeader
     * Return an instance with the provided value replacing the specified header.
     *
     * While header names are case-insensitive, the casing of the header will
     * be preserved by this function, and returned from getHeaders().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new and/or updated header and value.
     *
     * @param string $name Case-insensitive header field name.
     * @param string|string[] $value Header value(s).
     * @return static
     * @throws InvalidArgumentException for invalid header names or values.
     */
    public function withHeader($name, $value) : Message
    {
        if ((isset($name) && is_string($name)) && isset($value)) {
            $this->headers[$name] = is_array($value) ? $value : [$value];
        } else {
            throw new InvalidArgumentException("Invalid Header name '$name' or value '$value' .");
        }
        return $this;
    }


    /**
     * Function withHeaders
     *
     * Pass an array of headers to replace the current one in a single run.
     *
     * @param array $headers
     * @return Message
     * @throws InvalidArgumentException
     */
    public function withHeaders(array $headers) : Message
    {
        if (count($headers) >= 1) {
            foreach ($headers as $key => $value) {
                if (preg_match('/^[a-zA-Z-_]{0,}$/', $key)) {
                    $this->withOutHeader(strtolower($key));
                    if (is_array($value)) {
                        foreach ($value as $item_value) {
                            $this->withAddedHeader(strtolower($key), $item_value);
                        }
                    } else {
                        $this->withAddedHeader(strtolower($key), $value);
                    }
                } else {
                    throw new InvalidArgumentException("Invalid header key: $key . An string [a-zA-Z-_] was expected.");
                }
            }
        } else {
            throw new InvalidArgumentException("Invalid headers. An array was expected.");
        }
        return $this;
    }


    /**
     * FunctionwithAddedHeader
     * Return an instance with the specified header appended with the given value.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new header and/or value.
     *
     * @param string $name Case-insensitive header field name to add.
     * @param string|string[] $value Header value(s).
     * @return Message
     * @throws InvalidArgumentException for invalid header names or values.
     */
    public function withAddedHeader($name, $value) : Message
    {
        if (isset($name) && isset($value)) {
            $name = strtolower($name);

            if (is_array($value)) {
                foreach ($value as $vl) {
                    $this->headers[$name][] = $vl;
                }
                return $this;
            }

            if (isset($this->headers[$name])) {
                $old_value = $this->headers[$name];
                if (!is_array($old_value)) {
                    $this->headers[$name][] = $old_value;
                }
            }
            $this->headers[$name][] = $value;
            return $this;
        }
        throw new InvalidArgumentException("Invalid Header name '$name' or value '$value'.");
        return $this;
    }



    /**
     * Function withoutHeader
     * Return an instance without the specified header.
     *
     * Header resolution MUST be done without case-sensitivity.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the named header.
     *
     * @param string $name Case-insensitive header field name to remove.
     * @return static
     */
    public function withoutHeader($name) : Message
    {
        $name = strtolower($name);
        $this->headers[$name] = [];
        return $this;
    }


    /**
     * Function getBody
     * Gets the body of the message.
     *
     * @return Stream Returns the body as a stream.
     */
    public function getBody() : Stream
    {
        return $this->body ?? $this->body = (new StreamFactory())->createStream();
    }


    /**
     * Function withBody
     * Return an instance with the specified message body.
     *
     * The body MUST be a StreamInterface object.
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * new body stream.
     *
     * @param Stream $body Body.
     * @return static
     * @throws InvalidArgumentException When the body is not valid.
     */
    public function withBody(StreamInterface $body) : Message
    {
        if (is_null($body) && !($body instanceof StreamInterface)) {
            $this->body = (new StreamFactory())->createStream();
            throw new InvalidArgumentException("When the body is not valid.");
        }
        $this->body = $body;
        return $this;
    }

    /**
     * Function parseHeaders
     *  Pass an array of lines to the current header, if the parameter $rewrite === false.
     *
     *  The value of the line will be added to the header with the same key,
     *  otherwise the value of the current header will be replaced.
     *  $rewrite default:true
     *
     * @param array $headers
     * @param boolean $rewrite default:true
     * @return Message
     */
    public function parseHeaders(array $headers, bool $rewrite = true) : Message
    {
        foreach ($headers as $value) {
            $this->parseHeader($value);
        }
        return $this;
    }


     /**
     * Function parseHeader
     * Pass an line to the current header, if the parameter $rewrite === false
     *
     * The value of the line will be added to the header with the same key,
     * otherwise the value of the current header will be replaced.
     * $rewrite true
     *
     * @param array $headers
     * @param boolean $rewrite = true
     * @return Message
     */
    public function parseHeader(string $header, bool $rewrite = true) : Message
    {
        $line = explode(':', $header, 2);
        if (isset($line[1])) {
            $name = strtolower(trim($line[0]));
            $value = trim($line[1]);
            if ($rewrite === true) {
                return $this->withHeader($name, $value);
            }
            return $this->withAddedHeader($name, $value);
        }

        if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $header, $out)) {
            if ($rewrite) {
                return $this->withHeader("", $header)
                            ->withStatus(intval($out[1]));
            }
            return $this->withAddedHeader("", $header)
                        ->withStatus(intval($out[1]));
        }
        return $this;
    }
}
