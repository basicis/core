# Basicis\Core\Annotations  

Annotations Class
Describes a Annotations instance, and works with the comment blocks





## Methods

| Name | Description |
|------|-------------|
|[__construct](#annotations__construct)|Function __construct
Receives a class as an argument, and works with the comment blocks|
|[getClass](#annotationsgetclass)|Function getClass
Getting a annotations ReflectionClass|
|[getClassCommentByTag](#annotationsgetclasscommentbytag)|Function getCommentByTag
Get a documentation bloc line by any tag, and return this line|
|[getMethod](#annotationsgetmethod)|Function getMethod
Getting a annotations ReflectionMethod|
|[getMethodCommentByTag](#annotationsgetmethodcommentbytag)|Function getCommentByTag
Get a documentation bloc line by any tag, and return this line|
|[setClass](#annotationssetclass)|Function setClass
Setting class for extract annotations|
|[setMethod](#annotationssetmethod)|Function setMethod
Setting a method into a instance of ReflectionClass for extract annotations|




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
Getting a annotations ReflectionClass 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ReflectionClass|null`




<hr />


### Annotations::getClassCommentByTag  

**Description**

```php
public getClassCommentByTag (string $method, string $tag, int $index)
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
Getting a annotations ReflectionMethod 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ReflectionMethod|null`




<hr />


### Annotations::getMethodCommentByTag  

**Description**

```php
public getMethodCommentByTag (string $method, string $tag, int $index)
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


### Annotations::setClass  

**Description**

```php
public setClass (string $class)
```

Function setClass
Setting class for extract annotations 

 

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
Setting a method into a instance of ReflectionClass for extract annotations 

 

**Parameters**

* `(string) $method`

**Return Values**

`\Annotations`




<hr />

