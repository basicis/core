# Basicis\Model\DataBase  

DataBase Class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#database__construct)|Function __construct|
|[getManager](#databasegetmanager)|Function getManager|
|[setDBConfig](#databasesetdbconfig)|Function setDBConfig|
|[setORMConfig](#databasesetormconfig)|Function setORMConfig|




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


### DataBase::getManager  

**Description**

```php
public getManager (void)
```

Function getManager 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\EntityManager|null`




<hr />


### DataBase::setDBConfig  

**Description**

```php
public setDBConfig (string $user, string $pass, string $dbname, string $host, int $port, string $driver, string $path)
```

Function setDBConfig 

 

**Parameters**

* `(string) $user`
* `(string) $pass`
* `(string) $dbname`
* `(string) $host`
* `(int) $port`
* `(string) $driver`
* `(string) $path`

**Return Values**

`void`




<hr />


### DataBase::setORMConfig  

**Description**

```php
public setORMConfig (array $entityPaths, bool $isDevMode)
```

Function setORMConfig 

 

**Parameters**

* `(array) $entityPaths`
* `(bool) $isDevMode`

**Return Values**

`void`




<hr />

