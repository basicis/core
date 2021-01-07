# Basicis\Http\Message\UploadedFileFactory  

UploadedFileFactory class

## Implements:
Psr\Http\Message\UploadedFileFactoryInterface



## Methods

| Name | Description |
|------|-------------|
|[createUploadedFile](#uploadedfilefactorycreateuploadedfile)|Function createUploadedFile
Create a new uploaded file.|
|[createUploadedFileFromFilename](#uploadedfilefactorycreateuploadedfilefromfilename)|Function createUploadedFileFromFilename
Create a new uploaded file from filename|
|[createUploadedFilesFromArray](#uploadedfilefactorycreateuploadedfilesfromarray)|Function createUploadedFilesFromArray|




### UploadedFileFactory::createUploadedFile  

**Description**

```php
public createUploadedFile (\StreamInterface $stream, int $size, int $error, string $clientFilename, string $clientMediaType)
```

Function createUploadedFile
Create a new uploaded file. 

If a size is not provided it will be determined by checking the size of  
the file. 

**Parameters**

* `(\StreamInterface) $stream`
: Underlying stream representing the  
uploaded file content.  
* `(int) $size`
: in bytes  
* `(int) $error`
: PHP file upload error  
* `(string) $clientFilename`
: Filename as provided by the client, if any.  
* `(string) $clientMediaType`
: Media type as provided by the client, if any.  

**Return Values**

`\UploadedFileInterface`




**Throws Exceptions**


`\InvalidArgumentException`
> If the file resource is not readable.

<hr />


### UploadedFileFactory::createUploadedFileFromFilename  

**Description**

```php
public createUploadedFileFromFilename (string $filename)
```

Function createUploadedFileFromFilename
Create a new uploaded file from filename 

 

**Parameters**

* `(string) $filename`

**Return Values**

`\UploadedFileInterface`




<hr />


### UploadedFileFactory::createUploadedFilesFromArray  

**Description**

```php
public createUploadedFilesFromArray (array $files)
```

Function createUploadedFilesFromArray 

 

**Parameters**

* `(array) $files`

**Return Values**

`array`




<hr />

