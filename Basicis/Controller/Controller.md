# Basicis\Controller\Controller  

Controller Class - Controller implements ControllerInterface,
all controller classes extend from this

## Implements:
Basicis\Controller\ControllerInterface



## Methods

| Name | Description |
|------|-------------|
|[all](#controllerall)|Function all
Find all a model items of the specified class|
|[create](#controllercreate)|Function create
Creates a model of the specified class|
|[delete](#controllerdelete)|Function delete
Delete a model of the specified class|
|[extractUniqueColumns](#controllerextractuniquecolumns)|Function extractUniqueColumns
Extract Unique Columns of model class and return these as array|
|[find](#controllerfind)|Function find
Find one a model item of the specified class|
|[getModelByAnnotation](#controllergetmodelbyannotation)|Undocumented function
Get annotations model class|
|[index](#controllerindex)|Function index
Default method|
|[update](#controllerupdate)|Function update
Update a model of the specified class|




### Controller::all  

**Description**

```php
public all (\Basicis\Basicis $app, \Models $models)
```

Function all
Find all a model items of the specified class 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(\Models) $models`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Controller::create  

**Description**

```php
public create (\Basicis\Basicis $app, object $args)
```

Function create
Creates a model of the specified class 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(object) $args`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Controller::delete  

**Description**

```php
public delete (\Basicis\Basicis $app, \Model $model, object $args)
```

Function delete
Delete a model of the specified class 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(\Model) $model`
* `(object) $args`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Controller::extractUniqueColumns  

**Description**

```php
public static extractUniqueColumns (string $class, array $args)
```

Function extractUniqueColumns
Extract Unique Columns of model class and return these as array 

 

**Parameters**

* `(string) $class`
* `(array) $args`

**Return Values**

`array`




<hr />


### Controller::find  

**Description**

```php
public find (\Basicis\Basicis $app, \Model $model, object $args)
```

Function find
Find one a model item of the specified class 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(\Model) $model`
* `(object) $args`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Controller::getModelByAnnotation  

**Description**

```php
public getModelByAnnotation (void)
```

Undocumented function
Get annotations model class 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`




<hr />


### Controller::index  

**Description**

```php
public index (\Basicis\Basicis $app, object $args)
```

Function index
Default method 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(object) $args`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Controller::update  

**Description**

```php
public update (\Basicis\Basicis $app, \Model $model, object $args)
```

Function update
Update a model of the specified class 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(\Model) $model`
* `(object) $args`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />

