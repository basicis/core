# Basicis\Model\Model  

Model class

 @ORM\MappedSuperclass  

## Implements:
Basicis\Model\ModelInterface, Stringable



## Methods

| Name | Description |
|------|-------------|
|[__construct](#model__construct)|Function function|
|[__toArray](#model__toarray)|Function __toArray
Get Entity Data as Array, without the propreties defined in the array property $protecteds|
|[__toString](#model__tostring)|Function __toString
Get Entity Data as Json, without the propreties defined in the array property $protecteds|
|[all](#modelall)|Function all
Find all entities|
|[delete](#modeldelete)|Function delete
Remove data of this entity of database|
|[find](#modelfind)|Function find
Find a entity by id|
|[findBy](#modelfindby)|Function findBy
Find all entities by any column match|
|[findOneBy](#modelfindoneby)|Function findOneBy
Find a entity by any column match|
|[getCreated](#modelgetcreated)|Function getCreated
Return entity created timestamp|
|[getId](#modelgetid)|Function getId
Return entity ID (unique on system identification)|
|[getManager](#modelgetmanager)|Function getManager
Get a instance of Doctrine ORM EntityManager an return this, or null|
|[getUpdated](#modelgetupdated)|Get updated.|
|[save](#modelsave)|Function save
Save data of this entity to database, use for create or update entities|
|[setCreated](#modelsetcreated)|Function setCreated.|
|[setUpdated](#modelsetupdated)|Function setUpdated
Return entity updated timestamp|




### Model::__construct  

**Description**

```php
public __construct (array|int|null $data)
```

Function function 

 

**Parameters**

* `(array|int|null) $data`

**Return Values**

`void`


<hr />


### Model::__toArray  

**Description**

```php
public __toArray (void)
```

Function __toArray
Get Entity Data as Array, without the propreties defined in the array property $protecteds 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`




<hr />


### Model::__toString  

**Description**

```php
public __toString (void)
```

Function __toString
Get Entity Data as Json, without the propreties defined in the array property $protecteds 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Model::all  

**Description**

```php
public static all (void)
```

Function all
Find all entities 

 

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
Remove data of this entity of database 

 

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
Find a entity by id 

 

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
Find all entities by any column match 

 

**Parameters**

* `(array) $findBy`

**Return Values**

`array|\Model[]|null`




<hr />


### Model::findOneBy  

**Description**

```php
public static findOneBy (array $findOneBy)
```

Function findOneBy
Find a entity by any column match 

 

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
Return entity created timestamp 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\DateTime`




<hr />


### Model::getId  

**Description**

```php
public getId (void)
```

Function getId
Return entity ID (unique on system identification) 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`int|null`




<hr />


### Model::getManager  

**Description**

```php
public static getManager (string $class)
```

Function getManager
Get a instance of Doctrine ORM EntityManager an return this, or null 

 

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
Save data of this entity to database, use for create or update entities 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Model`




<hr />


### Model::setCreated  

**Description**

```php
public setCreated (string $created)
```

Function setCreated. 

Set entity creation timestamp 

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
Return entity updated timestamp 

 

**Parameters**

* `(string) $updated`

**Return Values**

`\User`




<hr />

