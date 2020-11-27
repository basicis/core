<?php
namespace Basicis\Core;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Log Class
 * Describes a logger instance.
 *
 * The message MUST be a string or object implementing __toString().
 *
 * The message MAY contain placeholders in the form: {foo} where foo
 * will be replaced by the context data in key "foo".
 *
 * The context array can contain arbitrary data, the only assumption that
 * can be made by implementors is that if an Exception instance is given
 * to produce a stack trace, it MUST be in a key named "exception".
 *
 * See https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 * for the full interface specification.
 * @category Core
 * @package  Basicis/Core
  * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Core/Log.php
 */
class Log implements LoggerInterface
{
    /**
     * $_path variable
     * @var string
     */
    private $path;

    /**
     * $_email variable
     * @var string
     */
    private $email;

    /**
     * $_context variable
     * @var string
     */
    private $context;

    /**
     * __construct function
     *
     * @param string $path  - Path to root log directory
     * @param string $email - Email address for send log, default = null.
     * @return void
     */
    public function __construct(string $path = null, string $email = null)
    {
        if (is_null($path)) {
            $path = '../';
        }

        $this->path = $path.'log/'.Date('Y/m/');

        if (!is_null($email) && ($email != false)) {
            $this->email = $email;
        }
    }

    /**
     * Function interpolate
     * Interpolates context values into the message placeholders.
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return string
     */
    public function interpolate(string $message, array $context = array()) : string
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        $this->context = $context;
        foreach ($context as $key => $val) {
            // check that the value can be cast to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{'.$key.'}'] = $val;
            }
        }
        // interpolate replacement values into the message and return
        if (!is_null($this->context) && (count($this->context) >= 1)) {
            $replace['context'] = json_encode($this->context);
        }
        return strtr($message, $replace);
    }
    

    /**
     * Function log
     * Logs with an arbitrary level.
     *
     * @param mixed  $level   - emergency|alert|critical|error|warning|notice|info|debug
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        if (method_exists($this, $level)) {
            $this->$level($message, $context);
        }
    }


    /**
     * Function emergency
     * System is unusable.
     *
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->toEmail(LogLevel::EMERGENCY, $this->interpolate($message, $context));
        $this->toFile(LogLevel::EMERGENCY, $this->interpolate($message, $context));
    }

    /**
     * Function alert
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->toEmail(LogLevel::ALERT, $this->interpolate($message, $context));
        $this->toFile(LogLevel::ALERT, $this->interpolate($message, $context));
    }

    /**
     * Function critical
     * Critical conditions.
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->toFile(LogLevel::CRITICAL, $this->interpolate($message, $context));
    }

    /**
     * Function error
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->toFile(LogLevel::ERROR, $this->interpolate($message, $context));
    }

    /**
     * Function warning
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->toFile(LogLevel::WARNING, $this->interpolate($message, $context));
    }

    /**
     * Function notice
     * Normal but significant events.
     *
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->toFile(LogLevel::NOTICE, $this->interpolate($message, $context));
    }

    /**
     * Function info
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->toFile(LogLevel::INFO, $this->interpolate($message, $context));
    }

    /**
     * Funtion debug
     * Detailed debug information.
     *
     * @param string $message - Text message
     * @param array  $context - Array with context values
     * @return void
     */
    public function debug($message, array $context = array()) : ?bool
    {
        $this->toFile(LogLevel::DEBUG, $this->interpolate($message, $context));
    }

    /**
     * Function toFile
     * Write message in the log file
     *
     * @param string $level   - Log level
     * @param string $message - Text message
     * @return boolean
     */
    private function toFile(string $level, string $message) : bool
    {
        $filename = $this->path . Date("d") . '.log';
        if ($this->toFileJson($level, $message)) {
            return error_log($this->formatMessage($level, $message."\n"), 3, $filename);
        }
        return false;
    }

    /**
     * Function toFileJson
     * Write message in the log file as json
     *
     * @param string $level   - Log level
     * @param string $message - Text message
     * @return boolean
     */
    private function toFileJson(string $level, string $message) : bool
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0775, true);
        }

        $filename = $this->path. Date("d"). '.json';
        $jsonObj = null;

        if (file_exists($filename)) {
            $jsonObj = json_decode(file_get_contents($filename));
        }

        $jsonObj[] = $this->formatMessageToArray($level, $message);
        $jsonRes = fopen($filename, 'w');

        if (is_resource($jsonRes)) {
            fwrite($jsonRes, json_encode($jsonObj));
            fclose($jsonRes);
            return file_exists($filename);
        }
        return false;
    }

    /**
     * Function toFileJson
     * Send a log message for especified mail address or
     * write message in the log file.
     *
     * @param string $level   - Log level
     * @param string $message - Text message
     * @return boolean
     */
    private function toEmail(string $level, string $message) : bool
    {
        if (isset($this->email)) {
            return error_log($this->formatMessage($level, $message), 1, $this->email);
        } else {
            $this->toFile(
                'alert',
                "Log email is not defined in @ .env* file ou in "
                ."Log::class __construct function params."
                ."Set the variable APP_LOG_MAIL='inbox@mail.ex"
                ."so that the work continues correctly."
            );
            return $this->toFile($level, $message);
        }
    }


    /**
     * Function formatMessage
     * Format Message to file log line
     *
     * @param string $level       - Log level
     * @param string $message     - Text message
     * @param string $date_format - Default format "Y/m/d H:i:s"
     * @param string $format      - Default line message format "{date} | {message}"
     * @return string
     */
    public function formatMessage(
        string $level,
        string $message,
        string $date_format = 'Y/m/d H:i:s',
        string $format = "{date} | {message}"
    ) : string {
        $context['level'] = ucfirst($level);
        $context['date'] = Date($date_format);
        $context['message'] = $message;
        return $this->interpolate($format, $context);
    }

    /**
     * Function formatMessageToArray
     * Format Message line, and return this as array
     * Ex:
     * [
     *   "date" => Y/m/d H:i:s,
     *   "level" => "Level",
     *   "message" => "Text Message interpolated.",
     *   "context" => array()
     * ];
     *
     * @param string $level       - Log level
     * @param string $message     - Text message
     * @param string $date_format - Default format "Y/m/d H:i:s"
     * @return string
     */
    public function formatMessageToArray(string $level, string $message, string $date_format = 'Y/m/d H:i:s') : array
    {
        return [
            "date" => Date($date_format),
            "level" => ucfirst($level),
            "message" => $message,
            "context" => $this->context
        ];
    }
}
