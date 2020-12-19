# Basicis\Http\Message\Uri  

Uri class

## Implements:
Psr\Http\Message\UriInterface, Stringable



## Methods

| Name | Description |
|------|-------------|
|[__construct](#uri__construct)|Function __construct|
|[__toString](#uri__tostring)|Function __toString
Return the string representation as a URI reference.|
|[getAuthority](#urigetauthority)|Function getAuthority
Retrieve the authority component of the URI.|
|[getFragment](#urigetfragment)|Function getFragment
Retrieve the fragment component of the URI.|
|[getHost](#urigethost)|Function getHost
Retrieve the host component of the URI.|
|[getPath](#urigetpath)|Function getPath
Retrieve the path component of the URI.|
|[getPort](#urigetport)|Function getPort
Retrieve the port component of the URI.|
|[getQuery](#urigetquery)|Function getQuery
Retrieve the query string of the URI.|
|[getScheme](#urigetscheme)|Function getScheme
Retrieve the scheme component of the URI.|
|[getUserInfo](#urigetuserinfo)|Function getUserInfo
Retrieve the user information component of the URI.|
|[withFragment](#uriwithfragment)|Function withFragment
Return an instance with the specified URI fragment.|
|[withHost](#uriwithhost)|Function withHost
Return an instance with the specified host.|
|[withPath](#uriwithpath)|Function withPath
Return an instance with the specified path.|
|[withPort](#uriwithport)|Function withPort
Return an instance with the specified port.|
|[withQuery](#uriwithquery)|Function withQuery
Return an instance with the specified query string.|
|[withScheme](#uriwithscheme)|Function withScheme
Return an instance with the specified scheme.|
|[withUserInfo](#uriwithuserinfo)|Function withUserInfo
Return an instance with the specified user information.|




### Uri::__construct  

**Description**

```php
public __construct (string $target)
```

Function __construct 

 

**Parameters**

* `(string) $target`

**Return Values**

`void`


<hr />


### Uri::__toString  

**Description**

```php
public __toString (void)
```

Function __toString
Return the string representation as a URI reference. 

Depending on which components of the URI are present, the resulting  
string is either a full URI or relative reference according to RFC 3986,  
Section 4.1. The method concatenates the various components of the URI,  
using the appropriate delimiters:  
  
- If a scheme is present, it MUST be suffixed by ":".  
- If an authority is present, it MUST be prefixed by "//".  
- The path can be concatenated without delimiters. But there are two  
  cases where the path has to be adjusted to make the URI reference  
  valid as PHP does not allow to throw an exception in __toString():  
    - If the path is rootless and an authority is present, the path MUST  
      be prefixed by "/".  
    - If the path is starting with more than one "/" and no authority is  
      present, the starting slashes MUST be reduced to one.  
- If a query is present, it MUST be prefixed by "?".  
- If a fragment is present, it MUST be prefixed by "#". 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Uri::getAuthority  

**Description**

```php
public getAuthority (void)
```

Function getAuthority
Retrieve the authority component of the URI. 

If no authority information is present, this method MUST return an empty  
string.  
The authority syntax of the URI is:  
  <pre>  
  [user-info@]host[:port]  
  </pre>  
If the port component is not set or is the standard port for the current  
scheme, it SHOULD NOT be included. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The URI authority, in "[user-info@]host[:port]" format.


<hr />


### Uri::getFragment  

**Description**

```php
public getFragment (void)
```

Function getFragment
Retrieve the fragment component of the URI. 

If no fragment is present, this method MUST return an empty string.  
  
The leading "#" character is not part of the fragment and MUST NOT be  
added.  
  
The value returned MUST be percent-encoded, but MUST NOT double-encode  
any characters. To determine what characters to encode, please refer to  
RFC 3986, Sections 2 and 3.5. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The URI fragment.


<hr />


### Uri::getHost  

**Description**

```php
public getHost (void)
```

Function getHost
Retrieve the host component of the URI. 

If no host is present, this method MUST return an empty string.  
The value returned MUST be normalized to lowercase, per RFC 3986  
Section 3.2.2. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The URI host.


<hr />


### Uri::getPath  

**Description**

```php
public getPath (void)
```

Function getPath
Retrieve the path component of the URI. 

The path can either be empty or absolute (starting with a slash) or  
rootless (not starting with a slash). Implementations MUST support all  
three syntaxes.  
Normally, the empty path "" and absolute path "/" are considered equal as  
defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically  
do this normalization because in contexts with a trimmed base path, e.g.  
the front controller, this difference becomes significant. It's the task  
of the user to handle both "" and "/".  
The value returned MUST be percent-encoded, but MUST NOT double-encode  
any characters. To determine what characters to encode, please refer to  
RFC 3986, Sections 2 and 3.3.  
As an example, if the value should include a slash ("/") not intended as  
delimiter between path segments, that value MUST be passed in encoded  
form (e.g., "%2F") to the instance. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The URI path.


<hr />


### Uri::getPort  

**Description**

```php
public getPort (void)
```

Function getPort
Retrieve the port component of the URI. 

If a port is present, and it is non-standard for the current scheme,  
this method MUST return it as an integer. If the port is the standard port  
used with the current scheme, this method SHOULD return null.  
If no port is present, and no scheme is present, this method MUST return  
a null value.  
If no port is present, but a scheme is present, this method MAY return  
the standard port for that scheme, but SHOULD return null. 

**Parameters**

`This function has no parameters.`

**Return Values**

`null|int`

> The URI port.


<hr />


### Uri::getQuery  

**Description**

```php
public getQuery (void)
```

Function getQuery
Retrieve the query string of the URI. 

If no query string is present, this method MUST return an empty string.  
The leading "?" character is not part of the query and MUST NOT be  
added.  
The value returned MUST be percent-encoded, but MUST NOT double-encode  
any characters. To determine what characters to encode, please refer to  
RFC 3986, Sections 2 and 3.4.  
As an example, if a value in a key/value pair of the query string should  
include an ampersand ("&") not intended as a delimiter between values,  
that value MUST be passed in encoded form (e.g., "%26") to the instance. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The URI query string.


<hr />


### Uri::getScheme  

**Description**

```php
public getScheme (void)
```

Function getScheme
Retrieve the scheme component of the URI. 

If no scheme is present, this method MUST return an empty string.  
The value returned MUST be normalized to lowercase, per RFC 3986  
Section 3.1.  
The trailing ":" character is not part of the scheme and MUST NOT be  
added. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The URI scheme.


<hr />


### Uri::getUserInfo  

**Description**

```php
public getUserInfo (void)
```

Function getUserInfo
Retrieve the user information component of the URI. 

If no user information is present, this method MUST return an empty  
string.  
If a user is present in the URI, this will return that value;  
additionally, if the password is also present, it will be appended to the  
user value, with a colon (":") separating the values.  
  
The trailing "@" character is not part of the user information and MUST  
NOT be added. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The URI user information, in "username[:password]" format.


<hr />


### Uri::withFragment  

**Description**

```php
public withFragment (string $fragment)
```

Function withFragment
Return an instance with the specified URI fragment. 

This method MUST retain the state of the current instance, and return  
an instance that contains the specified URI fragment.  
  
Users can provide both encoded and decoded fragment characters.  
Implementations ensure the correct encoding as outlined in getFragment().  
  
An empty fragment value is equivalent to removing the fragment. 

**Parameters**

* `(string) $fragment`
: The fragment to use with the new instance.  

**Return Values**

`static`

> A new instance with the specified fragment.


<hr />


### Uri::withHost  

**Description**

```php
public withHost (string $host)
```

Function withHost
Return an instance with the specified host. 

This method MUST retain the state of the current instance, and return  
an instance that contains the specified host.  
An empty host value is equivalent to removing the host. 

**Parameters**

* `(string) $host`
: The hostname to use with the new instance.  

**Return Values**

`static`

> A new instance with the specified host.


**Throws Exceptions**


`\InvalidArgumentException`
> for invalid hostnames.

<hr />


### Uri::withPath  

**Description**

```php
public withPath (string $path)
```

Function withPath
Return an instance with the specified path. 

This method MUST retain the state of the current instance, and return  
an instance that contains the specified path.  
The path can either be empty or absolute (starting with a slash) or  
rootless (not starting with a slash). Implementations MUST support all  
three syntaxes.  
If the path is intended to be domain-relative rather than path relative then  
it must begin with a slash ("/"). Paths not starting with a slash ("/")  
are assumed to be relative to some base path known to the application or  
consumer.  
Users can provide both encoded and decoded path characters.  
Implementations ensure the correct encoding as outlined in getPath(). 

**Parameters**

* `(string) $path`
: The path to use with the new instance.  

**Return Values**

`static`

> A new instance with the specified path.


**Throws Exceptions**


`\InvalidArgumentException`
> for invalid paths.

<hr />


### Uri::withPort  

**Description**

```php
public withPort (null|int $port)
```

Function withPort
Return an instance with the specified port. 

This method MUST retain the state of the current instance, and return  
an instance that contains the specified port.  
Implementations MUST raise an exception for ports outside the  
established TCP and UDP port ranges.  
A null value provided for the port is equivalent to removing the port  
information. 

**Parameters**

* `(null|int) $port`
: The port to use with the new instance; a null value  
removes the port information.  

**Return Values**

`static`

> A new instance with the specified port.


**Throws Exceptions**


`\InvalidArgumentException`
> for invalid ports.

<hr />


### Uri::withQuery  

**Description**

```php
public withQuery (string $query)
```

Function withQuery
Return an instance with the specified query string. 

This method MUST retain the state of the current instance, and return  
an instance that contains the specified query string.  
Users can provide both encoded and decoded query characters.  
Implementations ensure the correct encoding as outlined in getQuery().  
An empty query string value is equivalent to removing the query string. 

**Parameters**

* `(string) $query`
: The query string to use with the new instance.  

**Return Values**

`static`

> A new instance with the specified query string.


**Throws Exceptions**


`\InvalidArgumentException`
> for invalid query strings.

<hr />


### Uri::withScheme  

**Description**

```php
public withScheme (string $scheme)
```

Function withScheme
Return an instance with the specified scheme. 

This method MUST retain the state of the current instance, and return  
an instance that contains the specified scheme.  
Implementations MUST support the schemes "http" and "https" case  
insensitively, and MAY accommodate other schemes if required.  
An empty scheme is equivalent to removing the scheme. 

**Parameters**

* `(string) $scheme`
: The scheme to use with the new instance.  

**Return Values**

`static`

> A new instance with the specified scheme.


**Throws Exceptions**


`\InvalidArgumentException`
> for invalid or unsupported schemes.

<hr />


### Uri::withUserInfo  

**Description**

```php
public withUserInfo (string $user, null|string $password)
```

Function withUserInfo
Return an instance with the specified user information. 

This method MUST retain the state of the current instance, and return  
an instance that contains the specified user information.  
Password is optional, but the user information MUST include the  
user; an empty string for the user is equivalent to removing user  
information. 

**Parameters**

* `(string) $user`
: The user name to use for authority.  
* `(null|string) $password`
: The password associated with $user.  

**Return Values**

`static`

> A new instance with the specified user information.


<hr />

