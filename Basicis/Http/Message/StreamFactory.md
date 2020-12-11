# Basicis\Http\Message\StreamFactory  

StreamFactory class

## Implements:
Psr\Http\Message\StreamFactoryInterface



## Methods

| Name | Description |
|------|-------------|
|[createStream](#streamfactorycreatestream)|Function createStream
Create a new stream from a string.|
|[createStreamFromFile](#streamfactorycreatestreamfromfile)|Function createStreamFromFile
Create a stream from an existing file.|
|[createStreamFromResource](#streamfactorycreatestreamfromresource)|Create a new stream from an existing resource.|




### StreamFactory::createStream  

**Description**

```php
public createStream (string $content)
```

Function createStream
Create a new stream from a string. 

The stream SHOULD be created with a temporary resource. 

**Parameters**

* `(string) $content`
: String content with which to populate the stream.  

**Return Values**

`\StreamInterface`




<hr />


### StreamFactory::createStreamFromFile  

**Description**

```php
public createStreamFromFile (string $filename, string $mode)
```

Function createStreamFromFile
Create a stream from an existing file. 

The file MUST be opened using the given mode, which may be any mode  
supported by the `fopen` function.  
  
The `$filename` MAY be any string supported by `fopen()`. 

**Parameters**

* `(string) $filename`
: Filename or stream URI to use as basis of stream.  
* `(string) $mode`
: Mode with which to open the underlying filename/stream.  

**Return Values**

`\StreamInterface`




**Throws Exceptions**


`\RuntimeException`
> If the file cannot be opened.

`\InvalidArgumentException`
> If the mode is invalid.

<hr />


### StreamFactory::createStreamFromResource  

**Description**

```php
public createStreamFromResource (resource $resource)
```

Create a new stream from an existing resource. 

The stream MUST be readable and may be writable. 

**Parameters**

* `(resource) $resource`
: PHP resource to use as basis of stream.  

**Return Values**

`\StreamInterface`




<hr />

