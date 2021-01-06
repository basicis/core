<?php
namespace Basicis\Http\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Basicis\Exceptions\InvalidArgumentException;

/**
 * UploadedFileFactory class
 *
 * @category Basicis/Http/Message
 * @package  Basicis/Http/Message
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Message/UploadedFileFactory.php
 */
class UploadedFileFactory implements UploadedFileFactoryInterface
{
    /**
     * Function createUploadedFile
     * Create a new uploaded file.
     *
     * If a size is not provided it will be determined by checking the size of
     * the file.
     *
     * @see http://php.net/manual/features.file-upload.post-method.php
     * @see http://php.net/manual/features.file-upload.errors.php
     *
     * @param StreamInterface $stream          Underlying stream representing the
     *                                         uploaded file content.
     * @param int             $size            in bytes
     * @param int             $error           PHP file upload error
     * @param string          $clientFilename  Filename as provided by the client, if any.
     * @param string          $clientMediaType Media type as provided by the client, if any.
     *
     * @return UploadedFileInterface
     *
     * @throws InvalidArgumentException If the file resource is not readable.
     */
    public function createUploadedFile(
        StreamInterface $stream,
        int $size = null,
        int $error = \UPLOAD_ERR_OK,
        string $clientFilename = null,
        string $tmpName = null,
        string $clientMediaType = null
    ): UploadedFileInterface {

        if (!$stream->isReadable()) {
            throw new InvalidArgumentException('The file resource is not readable.');
            return new UploadedFile();
        }

        return new UploadedFile($stream, $size, $error, $clientFilename, $tmpName, $clientMediaType);
    }

    /**
     * Function createUploadedFilesFromArray
     *
     * @param array $files
     *
     * @return array
     */
    public function createUploadedFilesFromArray(array $files) : array
    {
        $uploadedFiles = [];
        foreach ($files as $key => $file) {
            if (is_array($file) && file_exists($file["tmp_name"])) {
                $uploadedFiles[$key] = $this->createUploadedFile(
                    (new StreamFactory())->createStreamFromFile($file["tmp_name"], "rw"),
                    $file["size"] ?? null,
                    $file["error"] ?? \UPLOAD_ERR_OK,
                    $file["name"] ?? null,
                    $file["tmp_name"] ?? null,
                    $file["type"] ?? null
                );
            }

            if ($file instanceof UploadedFile) {
                $uploadedFiles[$key] = $file;
            }
        }

        return $uploadedFiles;
    }

    /**
     * Function createUploadedFileFromFilename
     * Create a new uploaded file from filename
     * @param string $filename
     *
     * @return UploadedFileInterface
     */
    public function createUploadedFileFromFilename(string $filename) : UploadedFileInterface
    {
        $stream = (new StreamFactory)->createStreamFromFile($filename);
        return $this->createUploadedFile(
            $stream,
            $stream->getSize(),
            \UPLOAD_ERR_OK,
            basename($filename),
            $stream->getMetadata("uri"),
            \MimeType\MimeType::getType($filename)
        );
    }
}
