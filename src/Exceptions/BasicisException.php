<?php
namespace Basicis\Exceptions;

use Psr\Log\LoggerInterface;
use Basicis\Basicis as App;

/**
 * BasicisException Class
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
 * @link     https://github.com/basicis/core/blob/master/src/Exceptions/BasicisException.php
 */
class BasicisException extends \Exception
{
    /**
     * $levels variable
     * @var array
     */
    private $levels = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug',
    ];

    /**
     * Function log
     *
     *  Levels
     *
     * - emergency
     * - alert
     * - critical
     * - error
     * - warning
     * - notice
     * - info
     * - debug
     *
     * @param string $level="error"
     * @param string $message=null
     * @param  array $context
     * @return BasicisException
     */
    public function log(string $level = null, $message = null, array $context = []) : BasicisException
    {
        if (!in_array($level, $this->levels) | is_null($level)) {
            $level="error";
        }
        if (is_null($message)) {
            $message = $this->getMessage();
        }

        $context_merge = array_merge(
            [
                "level" => ucfirst($level),
                "file" => $this->getFile(),
                "line" => $this->getLine(),
                "code" => $this->getCode(),
            ],
            $context
        );

        App::logger()->log(
            $level,
            "{level}: $message | With reference code {code}, on line {line} of file {file};\n{context}",
            $context_merge
        );
        return $this;
    }
}
