# Basicis\Http\Client\RequestException  

RequestException class
Exception for when a request failed.

Ex:
- Request is invalid (e.g. method is missing)
- Runtime request errors (e.g. the body stream is not seekable)  

## Implements:
Stringable, Throwable, Psr\Http\Client\ClientExceptionInterface, Psr\Http\Client\RequestExceptionInterface

## Extend:

Basicis\Http\Client\ClientException

## Methods

| Name | Description |
|------|-------------|
|[getRequest](#requestexceptiongetrequest)|Function getRequest
Returns the request.|

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
|setRequest|Function setRequest|



### RequestException::getRequest  

**Description**

```php
public getRequest (void)
```

Function getRequest
Returns the request. 

The request object MAY be a different object from the one passed to ClientInterface::sendRequest() 

**Parameters**

`This function has no parameters.`

**Return Values**

`\RequestInterface`




<hr />

