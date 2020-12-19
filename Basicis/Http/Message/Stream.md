# Basicis\Http\Message\Stream  

Stream class
Describes a data stream.

Typically, an instance will wrap a PHP stream; this interface provides
a wrapper around the most common operations, including serialization of
the entire stream to a string.  

## Implements:
Psr\Http\Message\StreamInterface, Stringable



## Methods

| Name | Description |
|------|-------------|
|[__construct](#stream__construct)|Function __construct|
|[__toString](#stream__tostring)|Function __toString
Reads all data from the stream into a string, from the beginning to end.|
|[close](#streamclose)|Function close|
|[detach](#streamdetach)|Function detach
Separates any underlying resources from the stream.|
|[eof](#streameof)|Function eof
Returns true if the stream is at the end of the stream.|
|[getContents](#streamgetcontents)|Function getContents
Returns the remaining contents in a string|
|[getMetadata](#streamgetmetadata)|Function getMetadata
Get stream metadata as an associative array or retrieve a specific key.|
|[getSize](#streamgetsize)|Function getSize
Get the size of the stream if known.|
|[isReadable](#streamisreadable)|Function isReadable
Returns whether or not the stream is readable.|
|[isSeekable](#streamisseekable)|Function isSeekable
Returns whether or not the stream is seekable.|
|[isValidResource](#streamisvalidresource)|Function isValidResource|
|[isWritable](#streamiswritable)|Function isWritable
Returns whether or not the stream is writable.|
|[read](#streamread)|Function read
Read data from the stream.|
|[rewind](#streamrewind)|Function rewind
Seek to the beginning of the stream.|
|[seek](#streamseek)|Function seek
Seek to a position in the stream.|
|[tell](#streamtell)|Function tell
Returns the current position of the file read/write pointer|
|[write](#streamwrite)|Function write
Write data to the stream.|




### Stream::__construct  

**Description**

```php
public __construct (resource $resource, array $options)
```

Function __construct 

 

**Parameters**

* `(resource) $resource`
* `(array) $options`

**Return Values**

`void`


<hr />


### Stream::__toString  

**Description**

```php
public __toString (void)
```

Function __toString
Reads all data from the stream into a string, from the beginning to end. 

This method MUST attempt to seek to the beginning of the stream before  
reading data and read the stream until the end is reached.  
  
Warning: This could attempt to load a large amount of data into memory.  
  
This method MUST NOT raise an exception in order to conform with PHP's  
string casting operations. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




**Throws Exceptions**


`\Exception`


<hr />


### Stream::close  

**Description**

```php
public close (void)
```

Function close 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />


### Stream::detach  

**Description**

```php
public detach (void)
```

Function detach
Separates any underlying resources from the stream. 

After the stream has been detached, the stream is in an unusable state. 

**Parameters**

`This function has no parameters.`

**Return Values**

`\resource|null`

> Underlying PHP stream, if any


<hr />


### Stream::eof  

**Description**

```php
public eof (void)
```

Function eof
Returns true if the stream is at the end of the stream. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Stream::getContents  

**Description**

```php
public getContents (void)
```

Function getContents
Returns the remaining contents in a string 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




**Throws Exceptions**


`\RuntimeException`
> if unable to read or an error occurs while  
reading.

<hr />


### Stream::getMetadata  

**Description**

```php
public getMetadata (string $key)
```

Function getMetadata
Get stream metadata as an associative array or retrieve a specific key. 

The keys returned are identical to the keys returned from PHP's  
stream_get_meta_data() function. 

**Parameters**

* `(string) $key`
: Specific metadata to retrieve.  

**Return Values**

`array|mixed|null`

> Returns an associative array if no key is  
provided. Returns a specific key value if a key is provided and the  
value is found, or null if the key is not found.


<hr />


### Stream::getSize  

**Description**

```php
public getSize (void)
```

Function getSize
Get the size of the stream if known. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`int|null`

> Returns the size in bytes if known, or null if unknown.


<hr />


### Stream::isReadable  

**Description**

```php
public isReadable (void)
```

Function isReadable
Returns whether or not the stream is readable. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Stream::isSeekable  

**Description**

```php
public isSeekable (void)
```

Function isSeekable
Returns whether or not the stream is seekable. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Stream::isValidResource  

**Description**

```php
public isValidResource (void)
```

Function isValidResource 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Stream::isWritable  

**Description**

```php
public isWritable (void)
```

Function isWritable
Returns whether or not the stream is writable. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Stream::read  

**Description**

```php
public read (int $length)
```

Function read
Read data from the stream. 

 

**Parameters**

* `(int) $length`
: Read up to $length bytes from the object and return  
them. Fewer than $length bytes may be returned if underlying stream  
call returns fewer bytes.  

**Return Values**

`string`

> Returns the data read from the stream, or an empty string  
if no bytes are available.


**Throws Exceptions**


`\RuntimeException`
> if an error occurs.

<hr />


### Stream::rewind  

**Description**

```php
public rewind (void)
```

Function rewind
Seek to the beginning of the stream. 

If the stream is not seekable, this method will raise an exception;  
otherwise, it will perform a seek(0). 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


**Throws Exceptions**


`\RuntimeException`
> on failure.

<hr />


### Stream::seek  

**Description**

```php
public seek (int $offset, int $whence)
```

Function seek
Seek to a position in the stream. 

 

**Parameters**

* `(int) $offset`
: Stream offset  
* `(int) $whence`
: Specifies how the cursor position will be calculated  
based on the seek offset. Valid values are identical to the built-in  
PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to  
offset bytes SEEK_CUR: Set position to current location plus offset  
SEEK_END: Set position to end-of-stream plus offset.  

**Return Values**

`void`


**Throws Exceptions**


`\RuntimeException`
> on failure.

<hr />


### Stream::tell  

**Description**

```php
public tell (void)
```

Function tell
Returns the current position of the file read/write pointer 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`int`

> Position of the file pointer


**Throws Exceptions**


`\RuntimeException`
> on error.

<hr />


### Stream::write  

**Description**

```php
public write (string $string)
```

Function write
Write data to the stream. 

 

**Parameters**

* `(string) $string`
: The string that is to be written.  

**Return Values**

`int`

> Returns the number of bytes written to the stream.


**Throws Exceptions**


`\RuntimeException`
> on failure.

<hr />

