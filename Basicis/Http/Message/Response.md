# Basicis\Http\Message\Response  

Response class
Representation of an outgoing, server-side response.

Per the HTTP specification, this interface includes properties for
each of the following:

- Protocol version
- Status code and reason phrase
- Headers
- Message body

Responses are considered immutable; all methods that might change state MUST
be implemented such that they retain the internal state of the current
message and return an instance that contains the changed state.  

## Implements:
Psr\Http\Message\MessageInterface, Psr\Http\Message\ResponseInterface

## Extend:

Basicis\Http\Message\Message

## Methods

| Name | Description |
|------|-------------|
|[__construct](#response__construct)|Function ___contruct|
|[getReasonPhrase](#responsegetreasonphrase)|Function getReasonPhrase
Gets the response reason phrase associated with the status code.|
|[getStatusCode](#responsegetstatuscode)|Function getStatusCode
Gets the response status code.|
|[withStatus](#responsewithstatus)|Function withStatus
Return an instance with the specified status code and, optionally, reason phrase.|

## Inherited methods

| Name | Description |
|------|-------------|
|getBody|Function getBody
Gets the body of the message.|
|getHeader|Function getHeader
Retrieves a message header value by the given case-insensitive name.|
|getHeaderLine|Function getHeaderLine
Retrieves a comma-separated string of the values for a single header.|
|getHeaderLines|Function getHeaderLines|
|getHeaders|Funtion getHeaders
Retrieves all message header values
The keys represent the header name as it will be sent over the wire, and
each value is an array of strings associated with the header.|
|getProtocolVersion|Function getProtocolVersion
Retrieves the HTTP protocol version as a string.|
|hasHeader|Function hasHeader
Checks if a header exists by the given case-insensitive name.|
|normalizeHeaderKey|Function normalizeHeaderKey|
|parseHeader|Function parseHeader
Pass an line to the current header, if the parameter $rewrite === false,
the value of the line will be added to the header with the same key,
otherwise the value of the current header will be replaced.|
|parseHeaders|Function parseHeaders|
|withAddedHeader|FunctionwithAddedHeader
Return an instance with the specified header appended with the given value.|
|withBody|Function withBody
Return an instance with the specified message body.|
|withHeader|Function withHeader
Return an instance with the provided value replacing the specified header.|
|withHeaders|Function withHeaders|
|withProtocolVersion|Function withProtocolVersion
Return an instance with the specified HTTP protocol version.|
|withoutHeader|Function withoutHeader
Return an instance without the specified header.|



### Response::__construct  

**Description**

```php
public __construct (int $code, string $reasonPhrase)
```

Function ___contruct 

 

**Parameters**

* `(int) $code`
: default 200  
* `(string) $reasonPhrase`

**Return Values**

`void`




<hr />


### Response::getReasonPhrase  

**Description**

```php
public getReasonPhrase (void)
```

Function getReasonPhrase
Gets the response reason phrase associated with the status code. 

Because a reason phrase is not a required element in a response  
status line, the reason phrase value MAY be null. Implementations MAY  
choose to return the default RFC 7231 recommended reason phrase (or those  
listed in the IANA HTTP Status Code Registry) for the response's  
status code. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> Reason phrase; must return an empty string if none present.


<hr />


### Response::getStatusCode  

**Description**

```php
public getStatusCode (void)
```

Function getStatusCode
Gets the response status code. 

The status code is a 3-digit integer result code of the server's attempt  
to understand and satisfy the request. 

**Parameters**

`This function has no parameters.`

**Return Values**

`int`

> Status code.


<hr />


### Response::withStatus  

**Description**

```php
public withStatus (int $code, string $reasonPhrase)
```

Function withStatus
Return an instance with the specified status code and, optionally, reason phrase. 

If no reason phrase is specified, implementations MAY choose to default  
to the RFC 7231 or IANA recommended reason phrase for the response's  
status code.  
  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
updated status and reason phrase. 

**Parameters**

* `(int) $code`
: The 3-digit integer result code to set.  
* `(string) $reasonPhrase`
: The reason phrase to use with the  
provided status code; if none is provided, implementations MAY  
use the defaults as suggested in the HTTP specification.  

**Return Values**

`static`




**Throws Exceptions**


`\InvalidArgumentException`
> For invalid status code arguments.

<hr />

