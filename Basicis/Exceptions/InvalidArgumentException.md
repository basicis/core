# Basicis\Exceptions\InvalidArgumentException  

InvalidArgumentException Class
Exception extends \Exception
Every HTTP client related exception MUST implement this interface.

class Throwable {
 - public getMessage ( void ) : string

 - public getCode ( void ) : int

 - public getFile ( void ) : string

 - public getLine ( void ) : int

 - public getTrace ( void ) : array

 - public getTraceAsString ( void ) : string

 - public getPrevious ( void ) : Throwable

 - public __toString ( void ) : string

 - public function log() : void

}  

## Implements:
Throwable, Stringable

## Extend:

Basicis\Exceptions\BasicisException

## Methods

| Name | Description |
|------|-------------|

## Inherited methods

| Name | Description |
|------|-------------|
| [__construct](https://secure.php.net/manual/en/exception.__construct.php) | Construct the exception |
| [__toString](https://secure.php.net/manual/en/exception.__tostring.php) | String representation of the exception |
| [__wakeup](https://secure.php.net/manual/en/exception.__wakeup.php) | - |
| [getCode](https://secure.php.net/manual/en/exception.getcode.php) | Gets the Exception code |
| [getFile](https://secure.php.net/manual/en/exception.getfile.php) | Gets the file in which the exception was created |
| [getLine](https://secure.php.net/manual/en/exception.getline.php) | Gets the line in which the exception was created |
| [getMessage](https://secure.php.net/manual/en/exception.getmessage.php) | Gets the Exception message |
| [getPrevious](https://secure.php.net/manual/en/exception.getprevious.php) | Returns previous Exception |
| [getTrace](https://secure.php.net/manual/en/exception.gettrace.php) | Gets the stack trace |
| [getTraceAsString](https://secure.php.net/manual/en/exception.gettraceasstring.php) | Gets the stack trace as a string |
|log|Function log|


