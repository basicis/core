# Basicis\View\View  

View Class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#view__construct)|Function __construct|
|[getFunctions](#viewgetfunctions)|Function getFunctions
Get all defineds Twig functions|
|[getView](#viewgetview)|Fuction getView
Get a string result os template with optional $data array|
|[hasFunction](#viewhasfunction)|Function hasFunction
Check if has a Twig function named by $name argument|
|[setFilters](#viewsetfilters)|Function setFilters
Setting filters functions for use into template
- Setting into config/app-config.php file
```php
 $app->setViewFilters([
 //here, key is required
 "isTrue" => function ($value = true) {
     return $value;
 }
 ]);
```
- Using into Twig Template file
`{{isTrue($var = true)}}`|




### View::__construct  

**Description**

```php
public __construct (array $paths)
```

Function __construct 

 

**Parameters**

* `(array) $paths`

**Return Values**

`void`


<hr />


### View::getFunctions  

**Description**

```php
public getFunctions (void)
```

Function getFunctions
Get all defineds Twig functions 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`




<hr />


### View::getView  

**Description**

```php
public getView (string $name, array $data)
```

Fuction getView
Get a string result os template with optional $data array 

 

**Parameters**

* `(string) $name`
* `(array) $data`

**Return Values**

`string|null`




<hr />


### View::hasFunction  

**Description**

```php
public hasFunction (string $name)
```

Function hasFunction
Check if has a Twig function named by $name argument 

 

**Parameters**

* `(string) $name`

**Return Values**

`bool`




<hr />


### View::setFilters  

**Description**

```php
public setFilters (array $filters)
```

Function setFilters
Setting filters functions for use into template
- Setting into config/app-config.php file
```php
 $app->setViewFilters([
 //here, key is required
 "isTrue" => function ($value = true) {
     return $value;
 }
 ]);
```
- Using into Twig Template file
`{{isTrue($var = true)}}` 

 

**Parameters**

* `(array) $filters`

**Return Values**

`\View`




<hr />

