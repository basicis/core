# Basicis\Http\Message\UploadedFile  

UploadedFile class

Value object representing a file uploaded through an HTTP request.

Instances of this interface are considered immutable; all methods that
might change state MUST be implemented such that they retain the internal
state of the current instance and return an instance that contains the
changed state.  

## Implements:
Psr\Http\Message\UploadedFileInterface



## Methods

| Name | Description |
|------|-------------|
|[__construct](#uploadedfile__construct)|Function __construct|
|[getClientFilename](#uploadedfilegetclientfilename)|Function getClientFilename
Retrieve the filename sent by the client.|
|[getClientMediaType](#uploadedfilegetclientmediatype)|Function getClientMediaType
Retrieve the media type sent by the client.|
|[getError](#uploadedfilegeterror)|Function getError
Retrieve the error associated with the uploaded file.|
|[getSize](#uploadedfilegetsize)|Function getSize
Retrieve the file size.|
|[getStream](#uploadedfilegetstream)|Function getStream
Retrieve a stream representing the uploaded file.|
|[getTmpName](#uploadedfilegettmpname)|Function getTmpName
Retrieve the tmpName sent by the client.|
|[moveTo](#uploadedfilemoveto)|Function moveTo
Move the uploaded file to a new location.|




### UploadedFile::__construct  

**Description**

```php
public __construct (\StreamInterface $stream, int $size, int $error, string $clientFilename, string $clientMediaType)
```

Function __construct 

 

**Parameters**

* `(\StreamInterface) $stream`
* `(int) $size`
* `(int) $error`
* `(string) $clientFilename`
* `(string) $clientMediaType`

**Return Values**

`void`


<hr />


### UploadedFile::getClientFilename  

**Description**

```php
public getClientFilename (void)
```

Function getClientFilename
Retrieve the filename sent by the client. 

Do not trust the value returned by this method. A client could send  
a malicious filename with the intention to corrupt or hack your  
application.  
Implementations SHOULD return the value stored in the "name" key of  
the file in the $_FILES array. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`

> The filename sent by the client or null if none  
was provided.


<hr />


### UploadedFile::getClientMediaType  

**Description**

```php
public getClientMediaType (void)
```

Function getClientMediaType
Retrieve the media type sent by the client. 

Do not trust the value returned by this method. A client could send  
a malicious media type with the intention to corrupt or hack your  
application.  
Implementations SHOULD return the value stored in the "type" key of  
the file in the $_FILES array. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`

> The media type sent by the client or null if none  
was provided.


<hr />


### UploadedFile::getError  

**Description**

```php
public getError (void)
```

Function getError
Retrieve the error associated with the uploaded file. 

The return value MUST be one of PHP's UPLOAD_ERR_XXX constants.  
If the file was uploaded successfully, this method MUST return  
UPLOAD_ERR_OK.  
Implementations SHOULD return the value stored in the "error" key of  
the file in the $_FILES array. 

**Parameters**

`This function has no parameters.`

**Return Values**

`int`

> One of PHP's UPLOAD_ERR_XXX constants.


<hr />


### UploadedFile::getSize  

**Description**

```php
public getSize (void)
```

Function getSize
Retrieve the file size. 

Implementations SHOULD return the value stored in the "size" key of  
the file in the $_FILES array if available, as PHP calculates this based  
on the actual size transmitted. 

**Parameters**

`This function has no parameters.`

**Return Values**

`int|null`

> The file size in bytes or null if unknown.


<hr />


### UploadedFile::getStream  

**Description**

```php
public getStream (void)
```

Function getStream
Retrieve a stream representing the uploaded file. 

This method MUST return a StreamInterface instance, representing the  
uploaded file. The purpose of this method is to allow utilizing native PHP  
stream functionality to manipulate the file upload, such as  
stream_copy_to_stream() (though the result will need to be decorated in a  
native PHP stream wrapper to work with such functions).  
If the moveTo() method has been called previously, this method MUST raise  
an exception. 

**Parameters**

`This function has no parameters.`

**Return Values**

`\StreamInterface`

> Stream representation of the uploaded file.


**Throws Exceptions**


`\RuntimeException`
> in cases when no stream is available or can be  
created.

<hr />


### UploadedFile::getTmpName  

**Description**

```php
public getTmpName (void)
```

Function getTmpName
Retrieve the tmpName sent by the client. 

Do not trust the value returned by this method. A client could send  
a malicious filename with the intention to corrupt or hack your  
application.  
Implementations SHOULD return the value stored in the "tmp_name" key of  
the file in the $_FILES array. 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`

> The filename sent by the client or null if none  
was provided.


<hr />


### UploadedFile::moveTo  

**Description**

```php
public moveTo (string $targetPath)
```

Function moveTo
Move the uploaded file to a new location. 

Use this method as an alternative to move_uploaded_file(). This method is  
guaranteed to work in both SAPI and non-SAPI environments.  
Implementations must determine which environment they are in, and use the  
appropriate method (move_uploaded_file(), rename(), or a stream  
operation) to perform the operation.  
$targetPath may be an absolute path, or a relative path. If it is a  
relative path, resolution should be the same as used by PHP's rename()  
function.  
The original file or stream MUST be removed on completion.  
If this method is called more than once, any subsequent calls MUST raise  
an exception.  
When used in an SAPI environment where $_FILES is populated, when writing  
files via moveTo(), is_uploaded_file() and move_uploaded_file() SHOULD be  
used to ensure permissions and upload status are verified correctly.  
If you wish to move to a stream, use getStream(), as SAPI operations  
cannot guarantee writing to stream destinations. 

**Parameters**

* `(string) $targetPath`
: Path to which to move the uploaded file.  

**Return Values**

`void`


**Throws Exceptions**


`\InvalidArgumentException`
> if the $targetPath specified is invalid.

`\RuntimeException`
> on any error during the move operation, or on  
the second or subsequent call to the method.

<hr />

