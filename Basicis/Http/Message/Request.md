# Basicis\Http\Message\Request  

Request class
Representation of an outgoing, client-side request.

Per the HTTP specification, this interface includes properties for
each of the following:

- Protocol version
- HTTP method
- URI
- Headers
- Message body

During construction, implementations MUST attempt to set the Host header from
a provided URI if no Host header is provided.
Requests are considered immutable; all methods that might change state MUST
be implemented such that they retain the internal state of the current
message and return an instance that contains the changed state.  

## Implements:
Psr\Http\Message\MessageInterface, Psr\Http\Message\RequestInterface

## Extend:

Basicis\Http\Message\Message

## Methods

| Name | Description |
|------|-------------|
|[__construct](#request__construct)|Function __construct|
|[getContentData](#requestgetcontentdata)|Function getContentData|
|[getMethod](#requestgetmethod)|Function getMethod
Retrieves the HTTP method of the request.|
|[getRequestTarget](#requestgetrequesttarget)|Function getRequestTarget
Retrieves the message's request-target either as it will appear|
|[getUri](#requestgeturi)|Function getUri
Retrieves the URI instance.|
|[withContentData](#requestwithcontentdata)|Function withContentData|
|[withMethod](#requestwithmethod)|Function withMethod
Return an instance with the provided HTTP method.|
|[withRequestTarget](#requestwithrequesttarget)|Function withRequestTarget
Return an instance with the specific request-target.|
|[withUri](#requestwithuri)|Function withUri
Returns an instance with the provided URI.|

## Inherited methods

| Name | Description |
|------|-------------|
|getBody|Function getBody
Gets the body of the message.|
|getHeader|Function getHeader
Retrieves a message header value by the given case-insensitive name.|
|getHeaderLine|Function getHeaderLine|
|getHeaderLines|Function getHeaderLines|
|getHeaders|Funtion getHeaders
Retrieves all message header values|
|getProtocolVersion|Function getProtocolVersion
Retrieves the HTTP protocol version as a string.|
|hasHeader|Function hasHeader
Checks if a header exists by the given case-insensitive name.|
|normalizeHeaderKey|Function normalizeHeaderKey|
|parseHeader|Function parseHeader
Pass an line to the current header, if the parameter $rewrite === false|
|parseHeaders|Function parseHeaders
 Pass an array of lines to the current header, if the parameter $rewrite === false.|
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



### Request::__construct  

**Description**

```php
public __construct (string $target, string $method, array $data)
```

Function __construct 

 

**Parameters**

* `(string) $target`
: = null  
* `(string) $method`
: = 'GET' for Dafault  
* `(array) $data`
: [,$options = []]  

**Return Values**

`void`


<hr />


### Request::getContentData  

**Description**

```php
public getContentData (void)
```

Function getContentData 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`




<hr />


### Request::getMethod  

**Description**

```php
public getMethod (void)
```

Function getMethod
Retrieves the HTTP method of the request. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> Returns the request method.


<hr />


### Request::getRequestTarget  

**Description**

```php
public getRequestTarget (void)
```

Function getRequestTarget
Retrieves the message's request-target either as it will appear 

(forclients), as it appeared at request (for servers), or as it was  
specified for the instance (see withRequestTarget()).  
  
In most cases, this will be the origin-form of the composed URI,  
unless a value was provided to the concrete implementation (see  
withRequestTarget() below).  
  
If no URI is available, and no request-target has been specifically  
provided, this method MUST return the string "/". 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Request::getUri  

**Description**

```php
public getUri (void)
```

Function getUri
Retrieves the URI instance. 

This method MUST return a UriInterface instance. 

**Parameters**

`This function has no parameters.`

**Return Values**

`\UriInterface`

> Returns a UriInterface instance  
representing the URI of the request.


<hr />


### Request::withContentData  

**Description**

```php
public withContentData (array $data)
```

Function withContentData 

 

**Parameters**

* `(array) $data`

**Return Values**

`\Request`




**Throws Exceptions**


`\InvalidArgumentException`


<hr />


### Request::withMethod  

**Description**

```php
public withMethod (string $method)
```

Function withMethod
Return an instance with the provided HTTP method. 

While HTTP method names are typically all uppercase characters, HTTP  
method names are case-sensitive and thus implementations SHOULD NOT  
modify the given string.  
  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
changed request method. 

**Parameters**

* `(string) $method`
: Case-sensitive method.  

**Return Values**

`static`




**Throws Exceptions**


`\InvalidArgumentException`
> for invalid HTTP methods.

<hr />


### Request::withRequestTarget  

**Description**

```php
public withRequestTarget (mixed $requestTarget)
```

Function withRequestTarget
Return an instance with the specific request-target. 

If the request needs a non-origin-form request-target — e.g., for  
specifying an absolute-form, authority-form, or asterisk-form —  
this method may be used to create an instance with the specified  
request-target, verbatim.  
  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
changed request target. 

**Parameters**

* `(mixed) $requestTarget`

**Return Values**

`static`




<hr />


### Request::withUri  

**Description**

```php
public withUri (\UriInterface $uri, bool $preserveHost)
```

Function withUri
Returns an instance with the provided URI. 

This method MUST update the Host header of the returned request by  
default if the URI contains a host component. If the URI does not  
contain a host component, any pre-existing Host header MUST be carried  
over to the returned request.  
You can opt-in to preserving the original state of the Host header by  
setting `$preserveHost` to `true`. When `$preserveHost` is set to  
`true`, this method interacts with the Host header in the following ways:  
  
- If the Host header is missing or empty, and the new URI contains  
  a host component, this method MUST update the Host header in the returned  
  request.  
- If the Host header is missing or empty, and the new URI does not contain a  
  host component, this method MUST NOT update the Host header in the returned  
  request.  
- If a Host header is present and non-empty, this method MUST NOT update  
  the Host header in the returned request.  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
new UriInterface instance. 

**Parameters**

* `(\UriInterface) $uri`
: New request URI to use.  
* `(bool) $preserveHost`
: Preserve the original state of the Host header.  

**Return Values**

`static`




<hr />

