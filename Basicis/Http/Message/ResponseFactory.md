# Basicis\Http\Message\ResponseFactory  

ResponseFactory

## Implements:
Psr\Http\Message\ResponseFactoryInterface



## Methods

| Name | Description |
|------|-------------|
|[create](#responsefactorycreate)|Function create
Create a new response.|
|[createResponse](#responsefactorycreateresponse)|Function createResponse
Create a new response.|




### ResponseFactory::create  

**Description**

```php
public static create (int $code, string $reasonPhrase)
```

Function create
Create a new response. 

 

**Parameters**

* `(int) $code`
: HTTP status code; defaults to 200  
* `(string) $reasonPhrase`
: Reason phrase to associate with status code  
in generated response; if none is provided implementations MAY use  
the defaults as suggested in the HTTP specification.  

**Return Values**

`\ResponseInterface`




<hr />


### ResponseFactory::createResponse  

**Description**

```php
public createResponse (int $code, string $reasonPhrase)
```

Function createResponse
Create a new response. 

 

**Parameters**

* `(int) $code`
: HTTP status code; defaults to 200  
* `(string) $reasonPhrase`
: Reason phrase to associate with status code  
in generated response; if none is provided implementations MAY use  
the defaults as suggested in the HTTP specification.  

**Return Values**

`\ResponseInterface`




<hr />

