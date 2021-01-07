# Basicis\Controller\ControllerInterface  

ControllerInterface, all controller classes implements from this





## Methods

| Name | Description |
|------|-------------|
|[all](#controllerinterfaceall)|Function all
Find all a model items of the specified class|
|[create](#controllerinterfacecreate)|Function create
Creates a model of the specified class|
|[delete](#controllerinterfacedelete)|Function delete
Delete a model of the specified class|
|[find](#controllerinterfacefind)|Function find
Find one a model item of the specified class|
|[index](#controllerinterfaceindex)|Function index
Default method|
|[update](#controllerinterfaceupdate)|Function update
Update a model of the specified class|




### ControllerInterface::all  

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


### ControllerInterface::create  

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


### ControllerInterface::delete  

**Description**

```php
public delete (\Basicis\Basicis $app, \Basicis\Model\Model $model, object $args)
```

Function delete
Delete a model of the specified class 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(\Basicis\Model\Model) $model`
* `(object) $args`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### ControllerInterface::find  

**Description**

```php
public find (\Basicis\Basicis $app, \Basicis\Model\Model $model, object $args)
```

Function find
Find one a model item of the specified class 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(\Basicis\Model\Model) $model`
* `(object) $args`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### ControllerInterface::index  

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


### ControllerInterface::update  

**Description**

```php
public update (\Basicis\Basicis $app, \Basicis\Model\Model $model, object $args)
```

Function update
Update a model of the specified class 

 

**Parameters**

* `(\Basicis\Basicis) $app`
* `(\Basicis\Model\Model) $model`
* `(object) $args`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />

