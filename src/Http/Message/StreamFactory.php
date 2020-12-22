<?php
namespace Basicis\Http\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Basicis\Exceptions\BasicisException;
use Basicis\Exceptions\InvalidArgumentException;
use Basicis\Exceptions\RuntimeException;

/**
 * StreamFactory class
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/StreamFactory.php
 */
class StreamFactory implements StreamFactoryInterface
{
    /**
     * Function createStream
     * Create a new stream from a string.
     *
     * The stream SHOULD be created with a temporary resource.
     *
     * @param string $content String content with which to populate the stream.
     *
     * @return StreamInterface
     */
    public function createStream(string $content = ''): StreamInterface
    {
        $stream = new Stream(fopen(tempnam("/tmp", "tmpf"), 'w+', false), ['mode' => 'w+']);
        $stream->write($content);
        return $stream;
    }

    /**
     * Function createStreamFromFile
     * Create a stream from an existing file.
     *
     * The file MUST be opened using the given mode, which may be any mode
     * supported by the `fopen` function.
     *
     * The `$filename` MAY be any string supported by `fopen()`.
     *
     * @param string $filename Filename or stream URI to use as basis of stream.
     * @param string $mode     Mode with which to open the underlying filename/stream.
     *
     * @return StreamInterface
     * @throws RuntimeException If the file cannot be opened.
     * @throws InvalidArgumentException If the mode is invalid.
     */
    public function createStreamFromFile(string $filename, string $mode = 'w+'): StreamInterface
    {
        try {
            $resource = @fopen($filename, $mode, false);
            if (is_resource($resource)) {
                return new Stream($resource, ['mode' => $mode]);
            }
        } catch (Exception $e) {
            throw new RuntimeException("The file $filename cannot be opened.", 0, $e);
        }
        return $this->createStream("");
    }

    /**
     * Create a new stream from an existing resource.
     *
     * The stream MUST be readable and may be writable.
     *
     * @param resource $resource PHP resource to use as basis of stream.
     *
     * @return StreamInterface
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        return new Stream($resource);
    }
}
