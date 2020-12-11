# Basicis\Model\Model  

Model class

 @ORM\MappedSuperclass  

## Implements:
Basicis\Model\ModelInterface



## Methods

| Name | Description |
|------|-------------|
|[__construct](#model__construct)|Function __construct|
|[all](#modelall)|Function all|
|[delete](#modeldelete)|Function delete|
|[find](#modelfind)|Function find|
|[findBy](#modelfindby)|Function findBy|
|[findOneBy](#modelfindoneby)|Function findOneBy|
|[getCreated](#modelgetcreated)|Function getCreated|
|[getManager](#modelgetmanager)|Function getManager|
|[getUpdated](#modelgetupdated)|Get updated.|
|[save](#modelsave)|Function save|
|[setCreated](#modelsetcreated)|Function setCreated.|
|[setUpdated](#modelsetupdated)|Function setUpdated|




### Model::__construct  

**Description**

```php
public __construct (void)
```

Function __construct 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />


### Model::all  

**Description**

```php
public static all (void)
```

Function all 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`array|null`




<hr />


### Model::delete  

**Description**

```php
public delete (void)
```

Function delete 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Model::find  

**Description**

```php
public static find (array $id)
```

Function find 

 

**Parameters**

* `(array) $id`

**Return Values**

`\Model|null`




<hr />


### Model::findBy  

**Description**

```php
public static findBy (array $findBy)
```

Function findBy 

 

**Parameters**

* `(array) $findBy`

**Return Values**

`\Model|null`




<hr />


### Model::findOneBy  

**Description**

```php
public static findOneBy (array $findOneBy)
```

Function findOneBy 

 

**Parameters**

* `(array) $findOneBy`

**Return Values**

`\Model|null`




<hr />


### Model::getCreated  

**Description**

```php
public getCreated (void)
```

Function getCreated 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\DateTime`




<hr />


### Model::getManager  

**Description**

```php
public static getManager (string $class)
```

Function getManager 

 

**Parameters**

* `(string) $class`

**Return Values**

`\EntityManager|null`




<hr />


### Model::getUpdated  

**Description**

```php
public getUpdated (void)
```

Get updated. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\DateTime`




<hr />


### Model::save  

**Description**

```php
public save (void)
```

Function save 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Model::setCreated  

**Description**

```php
public setCreated (string $created)
```

Function setCreated. 

 

**Parameters**

* `(string) $created`

**Return Values**

`\Model`




<hr />


### Model::setUpdated  

**Description**

```php
public setUpdated (string $updated)
```

Function setUpdated 

 

**Parameters**

* `(string) $updated`

**Return Values**

`\User`




<hr />

