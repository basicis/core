# Basicis\Http\Client\ClientException  

ClientException class
Every HTTP client related exception MUST implement this interface.

- ClientException extends Basicis\Core\Exception  

## Implements:
Throwable, Psr\Http\Client\ClientExceptionInterface

## Extend:

Basicis\Exceptions\BasicisException

## Methods

| Name | Description |
|------|-------------|
|[setRequest](#clientexceptionsetrequest)|Function setRequest|

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



### ClientException::setRequest  

**Description**

```php
public setRequest (\Request $request)
```

Function setRequest 

 

**Parameters**

* `(\Request) $request`

**Return Values**

`\ClientException`




<hr />

