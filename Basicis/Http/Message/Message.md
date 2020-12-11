# Basicis\Http\Message\Message  

Message class

## Implements:
Psr\Http\Message\MessageInterface



## Methods

| Name | Description |
|------|-------------|
|[getBody](#messagegetbody)|Function getBody
Gets the body of the message.|
|[getHeader](#messagegetheader)|Function getHeader
Retrieves a message header value by the given case-insensitive name.|
|[getHeaderLine](#messagegetheaderline)|Function getHeaderLine
Retrieves a comma-separated string of the values for a single header.|
|[getHeaderLines](#messagegetheaderlines)|Function getHeaderLines|
|[getHeaders](#messagegetheaders)|Funtion getHeaders
Retrieves all message header values
The keys represent the header name as it will be sent over the wire, and
each value is an array of strings associated with the header.|
|[getProtocolVersion](#messagegetprotocolversion)|Function getProtocolVersion
Retrieves the HTTP protocol version as a string.|
|[hasHeader](#messagehasheader)|Function hasHeader
Checks if a header exists by the given case-insensitive name.|
|[normalizeHeaderKey](#messagenormalizeheaderkey)|Function normalizeHeaderKey|
|[parseHeader](#messageparseheader)|Function parseHeader
Pass an line to the current header, if the parameter $rewrite === false,
the value of the line will be added to the header with the same key,
otherwise the value of the current header will be replaced.|
|[parseHeaders](#messageparseheaders)|Function parseHeaders|
|[withAddedHeader](#messagewithaddedheader)|FunctionwithAddedHeader
Return an instance with the specified header appended with the given value.|
|[withBody](#messagewithbody)|Function withBody
Return an instance with the specified message body.|
|[withHeader](#messagewithheader)|Function withHeader
Return an instance with the provided value replacing the specified header.|
|[withHeaders](#messagewithheaders)|Function withHeaders|
|[withProtocolVersion](#messagewithprotocolversion)|Function withProtocolVersion
Return an instance with the specified HTTP protocol version.|
|[withoutHeader](#messagewithoutheader)|Function withoutHeader
Return an instance without the specified header.|




### Message::getBody  

**Description**

```php
public getBody (void)
```

Function getBody
Gets the body of the message. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Stream`

> Returns the body as a stream.


<hr />


### Message::getHeader  

**Description**

```php
public getHeader (string $name)
```

Function getHeader
Retrieves a message header value by the given case-insensitive name. 

This method returns an array of all the header values of the given  
case-insensitive header name.  
If the header does not appear in the message, this method MUST return an  
empty array. 

**Parameters**

* `(string) $name`
: Case-insensitive header field name.  

**Return Values**

`string[]`

> An array of string values as provided for the given  
header. If the header does not appear in the message, this method MUST  
return an empty array.


<hr />


### Message::getHeaderLine  

**Description**

```php
public getHeaderLine (string $name)
```

Function getHeaderLine
Retrieves a comma-separated string of the values for a single header. 

This method returns all of the header values of the given  
case-insensitive header name as a string concatenated together using  
a comma.  
NOTE: Not all header values may be appropriately represented using  
comma concatenation. For such headers, use getHeader() instead  
and supply your own delimiter when concatenating.  
If the header does not appear in the message, this method MUST return  
an empty string. 

**Parameters**

* `(string) $name`
: Case-insensitive header field name.  

**Return Values**

`string`

> A string of values as provided for the given header  
concatenated together using a comma. If the header does not appear in  
the message, this method MUST return an empty string.


<hr />


### Message::getHeaderLines  

**Description**

```php
public getHeaderLines (void)
```

Function getHeaderLines 

Retrieves all message header lines values in one array of string 

**Parameters**

`This function has no parameters.`

**Return Values**

`string[]`




<hr />


### Message::getHeaders  

**Description**

```php
public getHeaders (void)
```

Funtion getHeaders
Retrieves all message header values
The keys represent the header name as it will be sent over the wire, and
each value is an array of strings associated with the header. 

// Represent the headers as a string  
    foreach ($message->getHeaders() as $name => $values) {  
        echo $name . ": " . implode(", ", $values);  
    }  
  
    // Emit headers iteratively:  
    foreach ($message->getHeaders() as $name => $values) {  
        foreach ($values as $value) {  
            header(sprintf('%s: %s', $name, $value), false);  
        }  
    }  
  
While header names are not case-sensitive, getHeaders() will preserve the  
exact case in which headers were originally specified. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string[][]`

> Returns an associative array of the message's headers. Each  
key MUST be a header name, and each value MUST be an array of strings  
for that header.


<hr />


### Message::getProtocolVersion  

**Description**

```php
public getProtocolVersion (void)
```

Function getProtocolVersion
Retrieves the HTTP protocol version as a string. 

The string MUST contain only the HTTP version number (e.g., "1.0", "1.1"). 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> HTTP protocol version.


<hr />


### Message::hasHeader  

**Description**

```php
public hasHeader (string $name)
```

Function hasHeader
Checks if a header exists by the given case-insensitive name. 

 

**Parameters**

* `(string) $name`
: Case-insensitive header field name.  

**Return Values**

`bool`

> Returns true if any header names match the given header  
name using a case-insensitive string comparison. Returns false if  
no matching header name is found in the message.


<hr />


### Message::normalizeHeaderKey  

**Description**

```php
public normalizeHeaderKey (string $key)
```

Function normalizeHeaderKey 

 

**Parameters**

* `(string) $key`

**Return Values**

`string`




<hr />


### Message::parseHeader  

**Description**

```php
public parseHeader (array $headers, bool $rewrite)
```

Function parseHeader
Pass an line to the current header, if the parameter $rewrite === false,
the value of the line will be added to the header with the same key,
otherwise the value of the current header will be replaced. 

$rewrite default:true 

**Parameters**

* `(array) $headers`
* `(bool) $rewrite`
: = true  

**Return Values**

`\Message`




<hr />


### Message::parseHeaders  

**Description**

```php
public parseHeaders (array $headers, bool $rewrite)
```

Function parseHeaders 

Pass an array of lines to the current header, if the parameter $rewrite === false,  
the value of the line will be added to the header with the same key,  
otherwise the value of the current header will be replaced.  
$rewrite default:true 

**Parameters**

* `(array) $headers`
* `(bool) $rewrite`
: default:true  

**Return Values**

`\Message`




<hr />


### Message::withAddedHeader  

**Description**

```php
public withAddedHeader (string $name, string|string[] $value)
```

FunctionwithAddedHeader
Return an instance with the specified header appended with the given value. 

Existing values for the specified header will be maintained. The new  
value(s) will be appended to the existing list. If the header did not  
exist previously, it will be added.  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
new header and/or value. 

**Parameters**

* `(string) $name`
: Case-insensitive header field name to add.  
* `(string|string[]) $value`
: Header value(s).  

**Return Values**

`\Message`




**Throws Exceptions**


`\InvalidArgumentException`
> for invalid header names or values.

<hr />


### Message::withBody  

**Description**

```php
public withBody (\Stream $body)
```

Function withBody
Return an instance with the specified message body. 

The body MUST be a StreamInterface object.  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return a new instance that has the  
new body stream. 

**Parameters**

* `(\Stream) $body`
: Body.  

**Return Values**

`static`




**Throws Exceptions**


`\InvalidArgumentException`
> When the body is not valid.

<hr />


### Message::withHeader  

**Description**

```php
public withHeader (string $name, string|string[] $value)
```

Function withHeader
Return an instance with the provided value replacing the specified header. 

While header names are case-insensitive, the casing of the header will  
be preserved by this function, and returned from getHeaders().  
  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
new and/or updated header and value. 

**Parameters**

* `(string) $name`
: Case-insensitive header field name.  
* `(string|string[]) $value`
: Header value(s).  

**Return Values**

`static`




**Throws Exceptions**


`\InvalidArgumentException`
> for invalid header names or values.

<hr />


### Message::withHeaders  

**Description**

```php
public withHeaders (array $headers)
```

Function withHeaders 

Pass an array of headers to replace the current one in a single run. 

**Parameters**

* `(array) $headers`

**Return Values**

`\Message`




**Throws Exceptions**


`\InvalidArgumentException`


<hr />


### Message::withProtocolVersion  

**Description**

```php
public withProtocolVersion (string $version)
```

Function withProtocolVersion
Return an instance with the specified HTTP protocol version. 

The version string MUST contain only the HTTP version number (e.g.,  
"1.1", "1.0").  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that has the  
new protocol version. 

**Parameters**

* `(string) $version`
: HTTP protocol version  

**Return Values**

`static`




**Throws Exceptions**


`\InvalidArgumentExcepition`


<hr />


### Message::withoutHeader  

**Description**

```php
public withoutHeader (string $name)
```

Function withoutHeader
Return an instance without the specified header. 

Header resolution MUST be done without case-sensitivity.  
  
This method MUST be implemented in such a way as to retain the  
immutability of the message, and MUST return an instance that removes  
the named header. 

**Parameters**

* `(string) $name`
: Case-insensitive header field name to remove.  

**Return Values**

`static`




<hr />

