# Basicis\Core\Annotations  

Annotations Class
Describes a Annotations instance, and works with the comment blocks





## Methods

| Name | Description |
|------|-------------|
|[__construct](#annotations__construct)|Function __construct
Receives a class as an argument, and works with the comment blocks|
|[getClass](#annotationsgetclass)|Function getClass|
|[getCommentByTag](#annotationsgetcommentbytag)|Function getCommentByTag
Get a documentation bloc line by any tag, and return this line|
|[getMethod](#annotationsgetmethod)|Function getMethod|
|[setClass](#annotationssetclass)|Function setClass|
|[setMethod](#annotationssetmethod)|Function setMethod|




### Annotations::__construct  

**Description**

```php
public __construct (string $class)
```

Function __construct
Receives a class as an argument, and works with the comment blocks 

 

**Parameters**

* `(string) $class`

**Return Values**

`void`


<hr />


### Annotations::getClass  

**Description**

```php
public getClass (void)
```

Function getClass 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ReflectionClass|null`




<hr />


### Annotations::getCommentByTag  

**Description**

```php
public getCommentByTag (string $method, string $tag, int $index)
```

Function getCommentByTag
Get a documentation bloc line by any tag, and return this line 

 

**Parameters**

* `(string) $method`
* `(string) $tag`
* `(int) $index`

**Return Values**

`string|null`




<hr />


### Annotations::getMethod  

**Description**

```php
public getMethod (void)
```

Function getMethod 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ReflectionMethod|null`




<hr />


### Annotations::setClass  

**Description**

```php
public setClass (string $class)
```

Function setClass 

 

**Parameters**

* `(string) $class`

**Return Values**

`\Annotations`




<hr />


### Annotations::setMethod  

**Description**

```php
public setMethod (string $method)
```

Function setMethod 

 

**Parameters**

* `(string) $method`

**Return Values**

`\Annotations`




<hr />

