<?php
namespace  Basicis\Http\Message;

use Psr\Http\Message\StreamInterface;
use Basicis\Exceptions\InvalidArgumentException;
use Basicis\Exceptions\RuntimeException;
use Basicis\Exceptions\Exception;

/**
 * Stream class
 * Describes a data stream.
 * Typically, an instance will wrap a PHP stream; this interface provides
 * a wrapper around the most common operations, including serialization of
 * the entire stream to a string.
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/Stream.php
 */
class Stream implements StreamInterface
{
    /**
     * READABLE_MODES const
     */
    public const READABLE_MODES = '/r|a\+|ab\+|w\+|wb\+|x\+|xb\+|c\+|cb\+/';

    /**
     * WRITABLE_MODES const
     */
    public const WRITABLE_MODES = '/a|w|r\+|rb\+|rw|x|c/';


    /**
     * $resource variable
     *
     * @var [type]
     */
    private $resource;

    /**
     *  $size variable
     * @var int|null
     */
    private $size;

   /**
    * $seekable variable
    *
    * @var bool
    */
    private $seekable;

    /**
     * $readable variable
     *  @var bool
     */
    private $readable;


    /**
     * $writable variable
     * @var bool
     */
    private $writable;

    /**
     * $uri variable
     * @var string|null
     */
    private $uri;

   /**
    * $metadata variable
    * @var mixed[]
    */
    private $metadata;

    /**
    * $content variable
    * @var string
    */
    private $content;

    /**
     * Function __construct
     *
     * @param resource $resource
     * @param array $options
     */
    public function __construct($resource, array $options = [])
    {
        if (is_resource($resource)) {
            $this->resource =  $resource;

            if (!isset($options['mode'])) {
                $options['mode'] = 'r';
            }

            if (isset($options['size'])) {
                $this->size = $options['size'];
            }
            
            $this->metadata = $options['metadata'] ?? [];
            $meta = stream_get_meta_data($resource);
            $this->seekable = $meta['seekable'];
            $this->readable = (bool)preg_match(self::READABLE_MODES, $meta['mode']);
            $this->writable = (bool)preg_match(self::WRITABLE_MODES, $meta['mode']);
            $this->uri = $this->getMetadata('uri');
            return;
        }
        throw new InvalidArgumentException('Stream must be a resource');
    }

    /**
     * Function __toString
     * Reads all data from the stream into a string, from the beginning to end.
     *
     * This method MUST attempt to seek to the beginning of the stream before
     * reading data and read the stream until the end is reached.
     *
     * Warning: This could attempt to load a large amount of data into memory.
     *
     * This method MUST NOT raise an exception in order to conform with PHP's
     * string casting operations.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     * @return string
     * @throws Exception
     */
    public function __toString() : string
    {
        try {
            if ($this->isSeekable()) {
                $this->seek(0);
            }
            return $this->getContents();
        } catch (Exception $e) {
            if (\PHP_VERSION_ID >= 70400) {
                throw $e;
            }
            return '';
        }
    }

    /**
     * Function isValidResource
     *
     * @return boolean
     */
    public function isValidResource()
    {
        return isset($this->resource) && is_resource($this->resource);
    }

    /**
     * Function close
     *
     * @return void
     */
    public function close()
    {
        if ($this->isValidResource()) {
            fclose($this->resource);
        }
        $this->detach();
    }

    /**
     * Function detach
     * Separates any underlying resources from the stream.
     *
     * After the stream has been detached, the stream is in an unusable state.
     *
     * @return \resource|null Underlying PHP stream, if any
     */
    public function detach() : ?\resource
    {
        $this->size = $this->uri = null;
        $this->seekable = $this->writable = $this->readable =  false;
        return is_resource($this->resource) ? $this->resource : null;
    }

    /**
     * Function getSize
     * Get the size of the stream if known.
     *
     * @return int|null Returns the size in bytes if known, or null if unknown.
     */
    public function getSize() : ?int
    {
        // Clear the stat cache if the stream has a URI
        if ($this->uri) {
            clearstatcache(true, $this->uri);
        }

        return $this->isValidResource() ?  $this->size = fstat($this->resource)['size'] : null;
    }

    /**
     * Function tell
     * Returns the current position of the file read/write pointer
     *
     * @return int Position of the file pointer
     * @throws RuntimeException on error.
     */
    public function tell() : int
    {
        if (!$this->isValidResource()) {
            throw new InvalidArgumentException("Position of the file pointer is not valid.");
        }

        return ftell($this->resource);
    }

    
    /**
     * Function eof
     * Returns true if the stream is at the end of the stream.
     *
     * @return bool
     */
    public function eof() : bool
    {
        if (!$this->isValidResource()) {
            throw new RuntimeException('Stream is detached.');
        }

        return feof($this->resource);
    }


    /**
     * Function isSeekable
     * Returns whether or not the stream is seekable.
     *
     * @return bool
     */
    public function isSeekable(): bool
    {
        return $this->seekable;
    }


    /**
     * Function seek
     * Seek to a position in the stream.
     *
     * @link http://www.php.net/manual/en/function.fseek.php
     * @param int $offset Stream offset
     * @param int $whence Specifies how the cursor position will be calculated
     *     based on the seek offset. Valid values are identical to the built-in
     *     PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to
     *     offset bytes SEEK_CUR: Set position to current location plus offset
     *     SEEK_END: Set position to end-of-stream plus offset.
     * @throws RuntimeException on failure.
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        $whence = (int) $whence;
        if (!$this->isValidResource()) {
            throw new RuntimeException('Stream is detached.');
        }
        if (!$this->isSeekable()) {
            throw new RuntimeException('Stream is not seekable');
        }
        if (fseek($this->resource, $offset, $whence) === -1) {
            throw new RuntimeException('No find position to stream '
                . $offset . ' with whence ' . var_export($whence, true));
        }
    }


    /**
     * Function rewind
     * Seek to the beginning of the stream.
     *
     * If the stream is not seekable, this method will raise an exception;
     * otherwise, it will perform a seek(0).
     *
     * @see seek()
     * @link http://www.php.net/manual/en/function.fseek.php
     * @throws RuntimeException on failure.
     */
    public function rewind()
    {
        $this->seek(0);
    }


    /**
     * Function isWritable
     * Returns whether or not the stream is writable.
     *
     * @return bool
     */
    public function isWritable(): bool
    {
        return $this->writable;
    }

    /**
     * Function write
     * Write data to the stream.
     *
     * @param string $string The string that is to be written.
     * @return int Returns the number of bytes written to the stream.
     * @throws RuntimeException on failure.
     */
    public function write($string): int
    {
        if (!isset($this->resource)) {
            throw new RuntimeException('Stream is detached');
        }
        if (!$this->writable) {
            throw new RuntimeException('Cannot write to a non-writable stream');
        }

        // We can't know the size after writing anything
        $this->size = 0;
        $result = fwrite($this->resource, $string);
        if ($result === false) {
            throw new RuntimeException('Unable to write to stream');
        }
        return $this->size = $result;
    }




    /**
     * Function isReadable
     * Returns whether or not the stream is readable.
     *
     * @return bool
     */
    public function isReadable() : bool
    {
        return $this->readable;
    }


    /**
     * Function read
     * Read data from the stream.
     *
     * @param int $length Read up to $length bytes from the object and return
     *     them. Fewer than $length bytes may be returned if underlying stream
     *     call returns fewer bytes.
     * @return string Returns the data read from the stream, or an empty string
     *     if no bytes are available.
     * @throws RuntimeException if an error occurs.
     */
    public function read($length) : string
    {
        if (!isset($this->resource)) {
            throw new RuntimeException('Stream is detached.');
        }
        if (!$this->isReadable()) {
            throw new RuntimeException('Cannot read from non-readable stream.');
        }
        if ($length < 0) {
            throw new RuntimeException('Length parameter cannot be negative.');
        }
        if (0 === $length) {
            return '';
        }

        $string = fread($this->resource, $length);
        if (false === $string) {
            throw new RuntimeException('Unable to read from stream.');
        }
        return $string;
    }
    
    
    /**
     * Function getContents
     * Returns the remaining contents in a string
     *
     * @return string
     * @throws RuntimeException if unable to read or an error occurs while
     *     reading.
     */
    public function getContents(): string
    {
        if (!isset($this->resource)) {
            throw new RuntimeException('Stream is detached');
        }

        $contents = @stream_get_contents($this->resource);
        if ($contents === false) {
            throw new RuntimeException('Unable to read stream contents');
        }
        return $contents;
    }


    /**
     * Function getMetadata
     * Get stream metadata as an associative array or retrieve a specific key.
     *
     * The keys returned are identical to the keys returned from PHP's
     * stream_get_meta_data() function.
     *
     * @link http://php.net/manual/en/function.stream-get-meta-data.php
     * @param string $key Specific metadata to retrieve.
     * @return array|mixed|null Returns an associative array if no key is
     *     provided. Returns a specific key value if a key is provided and the
     *     value is found, or null if the key is not found.
     */
    public function getMetadata($key = null)
    {
        if (!isset($this->resource)) {
            return $key ? null : [];
        } elseif (!$key) {
            return $this->metadata + stream_get_meta_data($this->resource);
        } elseif (isset($this->metadata[$key])) {
            return $this->metadata[$key];
        }

        $meta = stream_get_meta_data($this->resource);
        return $meta[$key] ?? $meta ?? null;
    }
}
