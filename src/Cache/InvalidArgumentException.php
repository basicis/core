<?php
namespace Basicis\Cache;

/**
 * InvalidArgumentException class for invalid cache arguments.
 *
 * Any time an invalid argument is passed into a method it must throw an
 * exception class which implements Psr\Cache\InvalidArgumentException.
 *
 * @category Basicis/Cache
 * @package  Basicis/Cache
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Cache/InvalidArgumentException.php
 */
class InvalidArgumentException extends CacheException
{

}
