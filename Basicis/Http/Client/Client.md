# Basicis\Http\Client\Client  

Client class

## Implements:
Psr\Http\Client\ClientInterface



## Methods

| Name | Description |
|------|-------------|
|[connect](#clientconnect)|Function connect|
|[delete](#clientdelete)|Function delete|
|[get](#clientget)|Function get|
|[head](#clienthead)|Function head|
|[options](#clientoptions)|Function options|
|[path](#clientpath)|Function path|
|[post](#clientpost)|Function post|
|[purge](#clientpurge)|Function purge|
|[put](#clientput)|Function put|
|[sendRequest](#clientsendrequest)|Funtion sendRequest
Sends a PSR-7 request and returns a PSR-7 response.|
|[trace](#clienttrace)|Function trace|




### Client::connect  

**Description**

```php
public connect (string $uri, array $data)
```

Function connect 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::delete  

**Description**

```php
public delete (string $uri, array $data)
```

Function delete 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::get  

**Description**

```php
public get (string $uri, array $data, array $data)
```

Function get 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::head  

**Description**

```php
public head (string $uri, array $data)
```

Function head 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::options  

**Description**

```php
public options (string $uri, array $data)
```

Function options 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::path  

**Description**

```php
public path (string $uri, array $data)
```

Function path 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::post  

**Description**

```php
public post (string $uri, array $data)
```

Function post 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::purge  

**Description**

```php
public purge (string $uri, array $data)
```

Function purge 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::put  

**Description**

```php
public put (string $uri, array $data)
```

Function put 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />


### Client::sendRequest  

**Description**

```php
public sendRequest (\RequestInterface $request)
```

Funtion sendRequest
Sends a PSR-7 request and returns a PSR-7 response. 

 

**Parameters**

* `(\RequestInterface) $request`

**Return Values**

`\ResponseInterface`




**Throws Exceptions**


`\ClientException`
> If an error happens while processing the request.

<hr />


### Client::trace  

**Description**

```php
public trace (string $uri, array $data)
```

Function trace 

Instance a Request Interface object with the specified $method, $uri, $data, and $options,  
and returns a ResponseInterface instance. 

**Parameters**

* `(string) $uri`
* `(array) $data`
: [,$options = []]  

**Return Values**

`\ResponseInterface`




<hr />

