# Basicis\Model\DataBase  

DataBase Class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#database__construct)|Function __construct|
|[extractUrlParams](#databaseextracturlparams)|Function extractUrlParams
 Extract url a params to array ans return this|
|[getManager](#databasegetmanager)|Function getManager
Get a instance of Doctrine ORM EntityManager an return this, or null|
|[setDBConfig](#databasesetdbconfig)|Function setDBConfig
Set database configurations, driver, url and/or path (for sqlite)|
|[setORMConfig](#databasesetormconfig)|Function setORMConfig
Set database orm configurations, a array of entities paths and if is dev mode, for this, default value is true|




### DataBase::__construct  

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


### DataBase::extractUrlParams  

**Description**

```php
public extractUrlParams (string $url)
```

Function extractUrlParams
 Extract url a params to array ans return this 

 

**Parameters**

* `(string) $url`
: Database url on format driver://user:pass@host:port/dbname  

**Return Values**

`array`




<hr />


### DataBase::getManager  

**Description**

```php
public getManager (void)
```

Function getManager
Get a instance of Doctrine ORM EntityManager an return this, or null 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\EntityManager|null`




<hr />


### DataBase::setDBConfig  

**Description**

```php
public setDBConfig (array $options)
```

Function setDBConfig
Set database configurations, driver, url and/or path (for sqlite) 

 

**Parameters**

* `(array) $options`
: = ["driver" => null,"url" => null, "path" => null]  

**Return Values**

`void`




<hr />


### DataBase::setORMConfig  

**Description**

```php
public setORMConfig (array $entityPaths, bool $isDevMode)
```

Function setORMConfig
Set database orm configurations, a array of entities paths and if is dev mode, for this, default value is true 

 

**Parameters**

* `(array) $entityPaths`
* `(bool) $isDevMode`

**Return Values**

`void`




<hr />

