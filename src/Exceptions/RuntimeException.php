<?php
namespace Basicis\Exceptions;

/**
 * RuntimeException Class
 * Exception extends \Exception
 * Every HTTP client related exception MUST implement this interface.
 *
 * class Throwable {
 *   - public getMessage ( void ) : string
 *
 *   - public getCode ( void ) : int
 *
 *   - public getFile ( void ) : string
 *
 *   - public getLine ( void ) : int
 *
 *   - public getTrace ( void ) : array
 *
 *   - public getTraceAsString ( void ) : string
 *
 *   - public getPrevious ( void ) : Throwable
 *
 *   - public __toString ( void ) : string
 *
 *   - public function log() : void
 *
 *  }
 * @category Exceptions
 * @package  Basicis/Exceptions
  * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Exceptions/RuntimeException.php
 */
class RuntimeException extends BasicisException
{

}
