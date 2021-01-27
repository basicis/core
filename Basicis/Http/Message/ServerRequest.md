# Basicis\Http\Message\ServerRequest  

Representation of an incoming, server-side HTTP request.

Per the HTTP specification, this interface includes properties for
each of the following:

- Protocol version
- HTTP method
- URI
- Headers
- Message body

Additionally, it encapsulates all data as it has arrived to the
application from the CGI and/or PHP environment, including:

- The values represented in $_SERVER.
- Any cookies provided (generally via $_COOKIE)
- Query string arguments (generally via $_GET, or as parsed via parse_str())
- Upload files, if any (as represented by $_FILES)
- Deserialized body parameters (generally from $_POST)

$_SERVER values MUST be treated as immutable, as they represent application
state at the time of request; as such, no methods are provided to allow
modification of those values. The other values provide such methods, as they
can be restored from $_SERVER or the request body, and may need treatment
during the application (e.g., body parameters may be deserialized based on
content type).

Additionally, this interface recognizes the utility of introspecting a
request to derive and match additional parameters (e.g., via URI path
matching, decrypting cookie values, deserializing non-form-encoded body
content, matching authorization headers to users, etc). These parameters
are stored in an "attributes" property.

Requests are considered immutable; all methods that might change state MUST
be implemented such that they retain the internal state of the current
message and return an instance that contains the changed state.  

## Implements:
Psr\Http\Message\MessageInterface, Psr\Http\Message\RequestInterface, Psr\Http\Message\ServerRequestInterface

## Extend:

Basicis\Http\Message\Request

## Methods

| Name | Description |
|------|-------------|
|[getAttribute](#serverrequestgetattribute)|Function getAttribute
Retrieve a single derived request attribute.|
|[getAttributes](#serverrequestgetattributes)|Function getAttributes
Retrieve attributes derived from the request.|
|[getCookieParams](#serverrequestgetcookieparams)|Function getCookieParams
Retrieves cookies sent by the client to the server.|
|[getParsedBody](#serverrequestgetparsedbody)|Function getParsedBody
Retrieve any parameters provided in the request body.|
|[getQueryParams](#serverrequestgetqueryparams)|Function getQueryParams
Retrieve query string arguments.|
|[getQueryParamsByUri](#serverrequestgetqueryparamsbyuri)|Function getQueryParamsByUri
Get all query params passed by uri|
|[getServerParams](#serverrequestgetserverparams)|Function getServerParams
Retrieve server parameters.|
|[getUploadedFiles](#serverrequestgetuploadedfiles)|Function getUploadedFiles
Retrieve normalized file upload data.|
|[withAttribute](#serverrequestwithattribute)|Function withAttribute
Return an instance with the specified derived request attribute.|
|[withAttributes](#serverrequestwithattributes)|Function withAttributes
Return an instance with the specified derived request attribute.|
|[withCookieParams](#serverrequestwithcookieparams)|Function withCookieParams
Return an instance with the specified cookies.|
|[withParsedBody](#serverrequestwithparsedbody)|Function withParsedBody
Return an instance with the specified body parameters.|
|[withQueryParams](#serverrequestwithqueryparams)|Function withQueryParams
Return an instance with the specified query string arguments.|
|[withUploadedFiles](#serverrequestwithuploadedfiles)|Function withUploadedFiles
Create a new instance with the specified uploaded files.|
|[withoutAttribute](#serverrequestwithoutattribute)|Return an instance that removes the specified derived request attribute.|

## Inherited methods

| Name | Description |
|------|-------------|
|__construct|Function __construct|
|getBody|Function getBody
Gets the body of the message.|
|getContentData|Function getContentData|
|getHeader|Function getHeader
Retrieves a message header value by the given case-insensitive name.|
|getHeaderLine|Function getHeaderLine|
|getHeaderLines|Function getHeaderLines|
|getHeaders|Funtion getHeaders
Retrieves all message header values|
|getMethod|Function getMethod
Retrieves the HTTP method of the request.|
|getProtocolVersion|Function getProtocolVersion
Retrieves the HTTP protocol version as a string.|
|getRequestTarget|Function getRequestTarget
Retrieves the message's request-target either as it will appear|
|getUri|Function getUri
Retrieves the URI instance.|
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
|withContentData|Function withContentData|
|withHeader|Function withHeader
Return an instance with the provided value replacing the specified header.|
|withHeaders|Function withHeaders|
|withMethod|Function withMethod
Return an instance with the provided HTTP method.|
|withProtocolVersion|Function withProtocolVersion
Return an instance with the specified HTTP protocol version.|
|withRequestTarget|Function withRequestTarget
Return an instance with the specific request-target.|
|withUri|Function withUri
Returns an instance with the provided URI.|
|withoutHeader|Function withoutHeader
Return an instance without the specified header.|



### ServerRequest::getAttribute  

**Description**

```php
public getAttribute (string $name, mixed $default)
```

Function getAttribute
Retrieve a single derived request attribute. 

Retrieves a single derived request attribute as described in  
getAttributes(). If the attribute has not been previously set, returns  
the default value as provided.  
This method obviates the need for a hasAttribute() method, as it allows  
specifying a default value to return if the attribute is not found. 

**Parameters**

* `(string) $name`
: The attribute name.  
* `(mixed) $default`
: Default value to return if the attribute does not exist.  

**Return Values**

`mixed`




<hr />


### ServerRequest::getAttributes  

**Description**

```php
public getAttributes (void)
```

Function getAttributes
Retrieve attributes derived from the request. 

The request "attributes" may be used to allow injection of any  
parameters derived from the request: e.g., the results of path  
match operations; the results of decrypting cookies; the results of  
deserializing non-form-encoded message bodies; etc. Attributes  
will be application and request specific, and CAN be mutable. 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`

> Attributes derived from the request.


<hr />


### ServerRequest::getCookieParams  

**Description**

```php
public getCookieParams (void)
```

Function getCookieParams
Retrieves cookies sent by the client to the server. 

The data MUST be compatible with the structure of the $_COOKIE  
superglobal. 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`




<hr />


### ServerRequest::getParsedBody  

**Description**

```php
public getParsedBody (void)
```

Function getParsedBody
Retrieve any parameters provided in the request body. 

If the request Content-Type is either application/x-www-form-urlencoded  
or multipart/form-data, and the request method is POST, this method MUST  
return the contents of $_POST.  
Otherwise, this method may return any results of deserializing  
the request body content; as parsing returns structured content, the  
potential types MUST be arrays or objects only. A null value indicates  
the absence of body content. 

**Parameters**

`This function has no parameters.`

**Return Values**

`null|array|object`

> The deserialized body parameters, if any.  
These will typically be an array or object.


<hr />


### ServerRequest::getQueryParams  

**Description**

```php
public getQueryParams (void)
```

Function getQueryParams
Retrieve query string arguments. 

Retrieves the deserialized query string arguments, if any.  
  
Note: the query params might not be in sync with the URI or server  
params. If you need to ensure you are only getting the original  
values, you may need to parse the query string from `getUri()->getQuery()`  
or from the `QUERY_STRING` server param. 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`




<hr />


### ServerRequest::getQueryParamsByUri  

**Description**

```php
public getQueryParamsByUri (void)
```

Function getQueryParamsByUri
Get all query params passed by uri 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`




<hr />


### ServerRequest::getServerParams  

**Description**

```php
public getServerParams (void)
```

Function getServerParams
Retrieve server parameters. 

Retrieves data related to the incoming request environment,  
typically derived from PHP's $_SERVER superglobal. The data IS NOT  
REQUIRED to originate from $_SERVER. 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`




<hr />


### ServerRequest::getUploadedFiles  

**Description**

```php
public getUploadedFiles (void)
```

Function getUploadedFiles
Retrieve normalized file upload data. 

This method returns upload metadata in a normalized tree, with each leaf  
an instance of Psr\Http\Message\UploadedFileInterface.  
These values MAY be prepared from $_FILES or the message body during  
instantiation, or MAY be injected via withUploadedFiles(). 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`

> An array tree of UploadedFileInterface instances; an empty  
array MUST be returned if no data is present.


<hr />


### ServerRequest::withAttribute  

**Description**

```php
public withAttribute (string $name, mixed $value)
```

Function withAttribute
Return an instance with the specified derived request attribute. 

This method allows setting a single derived request attribute as  
described in getAttributes().  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
updated attribute. 

**Parameters**

* `(string) $name`
: The attribute name.  
* `(mixed) $value`
: The value of the attribute.  

**Return Values**

`static`




<hr />


### ServerRequest::withAttributes  

**Description**

```php
public withAttributes (array $attributes)
```

Function withAttributes
Return an instance with the specified derived request attribute. 

This method allows setting a single derived request attribute as  
described in getAttributes().  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
updated attribute. 

**Parameters**

* `(array) $attributes`
: The attribute name.  

**Return Values**

`static`




<hr />


### ServerRequest::withCookieParams  

**Description**

```php
public withCookieParams (array $cookies)
```

Function withCookieParams
Return an instance with the specified cookies. 

The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST  
be compatible with the structure of $_COOKIE. Typically, this data will  
be injected at instantiation.  
  
This method MUST NOT update the related Cookie header of the request  
instance, nor related values in the server params.  
  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
updated cookie values. 

**Parameters**

* `(array) $cookies`
: Array of key/value pairs representing cookies.  

**Return Values**

`static`




<hr />


### ServerRequest::withParsedBody  

**Description**

```php
public withParsedBody (null|string|array|object $data)
```

Function withParsedBody
Return an instance with the specified body parameters. 

These MAY be injected during instantiation.  
If the request Content-Type is either application/x-www-form-urlencoded  
or multipart/form-data, and the request method is POST, use this method  
ONLY to inject the contents of $_POST.  
The data IS NOT REQUIRED to come from $_POST, but MUST be the results of  
deserializing the request body content. Deserialization/parsing returns  
structured data, and, as such, this method ONLY accepts arrays or objects,  
or a null value if nothing was available to parse.  
As an example, if content negotiation determines that the request data  
is a JSON payload, this method could be used to create a request  
instance with the deserialized parameters.  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
updated body parameters. 

**Parameters**

* `(null|string|array|object) $data`
: The deserialized body data. This will  
typically be in an array or object.  

**Return Values**

`static`




**Throws Exceptions**


`\InvalidArgumentException`
> if an unsupported argument type is  
provided.

<hr />


### ServerRequest::withQueryParams  

**Description**

```php
public withQueryParams (array $query)
```

Function withQueryParams
Return an instance with the specified query string arguments. 

These values SHOULD remain immutable over the course of the incoming  
request. They MAY be injected during instantiation, such as from PHP's  
$_GET superglobal, or MAY be derived from some other value such as the  
URI. In cases where the arguments are parsed from the URI, the data  
MUST be compatible with what PHP's parse_str() would return for  
purposes of how duplicate query parameters are handled, and how nested  
sets are handled.  
  
Setting query string arguments MUST NOT change the URI stored by the  
request, nor the values in the server params.  
  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
updated query string arguments. 

**Parameters**

* `(array) $query`
: Array of query string arguments, typically from  
$_GET.  

**Return Values**

`static`




<hr />


### ServerRequest::withUploadedFiles  

**Description**

```php
public withUploadedFiles (array $uploadedFiles)
```

Function withUploadedFiles
Create a new instance with the specified uploaded files. 

This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
updated body parameters. 

**Parameters**

* `(array) $uploadedFiles`
: An array tree of UploadedFileInterface instances.  

**Return Values**

`static`




**Throws Exceptions**


`\InvalidArgumentException`
> if an invalid structure is provided.

<hr />


### ServerRequest::withoutAttribute  

**Description**

```php
public withoutAttribute (string $name)
```

Return an instance that removes the specified derived request attribute. 

This method allows removing a single derived request attribute as  
described in getAttributes().  
  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that removes  
the attribute. 

**Parameters**

* `(string) $name`
: The attribute name.  

**Return Values**

`static`




<hr />

