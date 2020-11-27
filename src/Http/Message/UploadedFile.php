<?php
namespace Basicis\Http\Message;

use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\StreamInterface;
use Basicis\Http\Message\Stream;
use Basicis\Exceptions\InvalidArgumentException;
use Basicis\Exceptions\RuntimeException;

/**
 * UploadedFile class
 *
 * Value object representing a file uploaded through an HTTP request.
 *
 * Instances of this interface are considered immutable; all methods that
 * might change state MUST be implemented such that they retain the internal
 * state of the current instance and return an instance that contains the
 * changed state.
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/UploadedFile.php
 */
class UploadedFile implements UploadedFileInterface
{
    /**
     * $stream variable
     *
     * @var Stream
     */
    private $stream;

    /**
     * $size variable
     *
     * @var int
     */
    private $size;

    /**
     * $error variable
     *
     * @var bool
     */
    private $error;

    /**
     * $clientFilename variable
     *
     * @var string
     */
    private $clientFilename;

    /**
     * $tmpName variable
     *
     * @var string
     */
    private $tmpName;

    /**
     * $clientMediaType variable
     *
     * @var string
     */
    private $clientMediaType;
    
    /**
     * Function __construct
     *
     * @param StreamInterface $stream
     * @param integer $size
     * @param integer $error
     * @param string $clientFilename
     * @param string $clientMediaType
     */
    public function __construct(
        StreamInterface $stream = null,
        int $size = null,
        int $error = 0,
        string $clientFilename = null,
        string $tmpName = null,
        string $clientMediaType = null
    ) {
        $this->error = $error;

        if (!is_null($size)) {
            $this->size = $size;
        }

        if (!is_null($stream)) {
            $this->stream = $stream;
        }

        if (!is_null($clientFilename)) {
            $this->clientFilename = $clientFilename;
        }
        if (!is_null($tmpName)) {
            $this->tmpName = $tmpName;
        }

        if (!is_null($clientMediaType)) {
            $this->clientMediaType = $clientMediaType;
        }
    }

    /**
     * Function getStream
     * Retrieve a stream representing the uploaded file.
     * This method MUST return a StreamInterface instance, representing the
     * uploaded file. The purpose of this method is to allow utilizing native PHP
     * stream functionality to manipulate the file upload, such as
     * stream_copy_to_stream() (though the result will need to be decorated in a
     * native PHP stream wrapper to work with such functions).
     * If the moveTo() method has been called previously, this method MUST raise
     * an exception.
     *
     * @return StreamInterface Stream representation of the uploaded file.
     * @throws RuntimeException in cases when no stream is available or can be
     *     created.
     */
    public function getStream() :  StreamInterface
    {
        if (isset($this->stream)) {
            return $this->stream;
        } else {
            throw new RuntimeException('No stream is available or can be created.');
        }
    }


    /**
     * Function moveTo
     * Move the uploaded file to a new location.
     * Use this method as an alternative to move_uploaded_file(). This method is
     * guaranteed to work in both SAPI and non-SAPI environments.
     * Implementations must determine which environment they are in, and use the
     * appropriate method (move_uploaded_file(), rename(), or a stream
     * operation) to perform the operation.
     * $targetPath may be an absolute path, or a relative path. If it is a
     * relative path, resolution should be the same as used by PHP's rename()
     * function.
     * The original file or stream MUST be removed on completion.
     * If this method is called more than once, any subsequent calls MUST raise
     * an exception.
     * When used in an SAPI environment where $_FILES is populated, when writing
     * files via moveTo(), is_uploaded_file() and move_uploaded_file() SHOULD be
     * used to ensure permissions and upload status are verified correctly.
     * If you wish to move to a stream, use getStream(), as SAPI operations
     * cannot guarantee writing to stream destinations.
     *
     * @see http://php.net/is_uploaded_file
     * @see http://php.net/move_uploaded_file
     * @param string $targetPath Path to which to move the uploaded file.
     * @throws InvalidArgumentException if the $targetPath specified is invalid.
     * @throws RuntimeException on any error during the move operation, or on
     *     the second or subsequent call to the method.
     */
    public function moveTo($targetPath)
    {
        if (isset($targetPath) && ( $targetPath != '')) {
            if (!is_dir(dirname($targetPath))) {
                mkdir(dirname($targetPath), 0755, true);
            }
            
            if ($this->getStream() instanceof StreamInterface && \is_uploaded_file($this->getTmpName())) {
                if (!move_uploaded_file($this->getTmpName(), $targetPath)) {
                    throw new RuntimeException('There is an error during the move uploaded File operation or on the second or subsequent call to the method.');
                }
            }
            return;
        }

        throw new InvalidArgumentException("TargetPath '$targetPath' specified is invalid.");
    }
    

    /**
     * Function getSize
     * Retrieve the file size.
     * Implementations SHOULD return the value stored in the "size" key of
     * the file in the $_FILES array if available, as PHP calculates this based
     * on the actual size transmitted.
     *
     * @return int|null The file size in bytes or null if unknown.
     */
    public function getSize() : ?int
    {
        return $this->size;
    }
    

    /**
     * Function getError
     * Retrieve the error associated with the uploaded file.
     * The return value MUST be one of PHP's UPLOAD_ERR_XXX constants.
     * If the file was uploaded successfully, this method MUST return
     * UPLOAD_ERR_OK.
     * Implementations SHOULD return the value stored in the "error" key of
     * the file in the $_FILES array.
     *
     * @see http://php.net/manual/en/features.file-upload.errors.php
     * @return int One of PHP's UPLOAD_ERR_XXX constants.
     */
    public function getError() : int
    {
        return $this->error;
    }
    
    /**
     * Function getClientFilename
     * Retrieve the filename sent by the client.
     * Do not trust the value returned by this method. A client could send
     * a malicious filename with the intention to corrupt or hack your
     * application.
     * Implementations SHOULD return the value stored in the "name" key of
     * the file in the $_FILES array.
     *
     * @return string|null The filename sent by the client or null if none
     *     was provided.
     */
    public function getClientFilename() : ?string
    {
        return $this->clientFilename;
    }

    /**
     * Function getTmpName
     * Retrieve the tmpName sent by the client.
     * Do not trust the value returned by this method. A client could send
     * a malicious filename with the intention to corrupt or hack your
     * application.
     * Implementations SHOULD return the value stored in the "tmp_name" key of
     * the file in the $_FILES array.
     *
     * @return string|null The filename sent by the client or null if none
     *     was provided.
     */
    public function getTmpName() : ?string
    {
        return $this->tmpName;
    }
    
    /**
     * Function getClientMediaType
     * Retrieve the media type sent by the client.
     * Do not trust the value returned by this method. A client could send
     * a malicious media type with the intention to corrupt or hack your
     * application.
     * Implementations SHOULD return the value stored in the "type" key of
     * the file in the $_FILES array.
     *
     * @return string|null The media type sent by the client or null if none
     *     was provided.
     */
    public function getClientMediaType() : ?string
    {
        return $this->clientMediaType;
    }
}
