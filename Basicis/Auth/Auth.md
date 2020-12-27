# Basicis\Auth\Auth  

Auth Class
Basicis default authentication class

## Implements:
Basicis\Model\ModelInterface, Stringable, Basicis\Auth\AuthInterface

## Extend:

Basicis\Model\Model

## Methods

| Name | Description |
|------|-------------|
|[checkPass](#authcheckpass)|Function checkPass
Check Auth password key|
|[getEmail](#authgetemail)|Function getEmail
Get Auth email|
|[getRole](#authgetrole)|Function getRole
Get role permission ID|
|[getRoleName](#authgetrolename)|Function getRoleName
Get role permission Name|
|[getUser](#authgetuser)|Function getUser
Get a Auth User by token and appKey|
|[getUsername](#authgetusername)|Function getUsername
Get Auth username|
|[login](#authlogin)|Function function
Check  Auth User and return a string token of on success or null in error case|
|[setEmail](#authsetemail)|Function setEmail
Set Auth email|
|[setPass](#authsetpass)|Function setPass
Set Auth password key|
|[setRole](#authsetrole)|Function setRole
Set role permission ID includes is Default roles permissions IDs 'DEFAULT_ROLES' or optional > 5|
|[setUsername](#authsetusername)|Function setUsername
Set Auth username|

## Inherited methods

| Name | Description |
|------|-------------|
|__construct|Function function|
|__toArray|Function __toArray
Get Entity Data as Array, without the propreties defined in the array property $protecteds|
|__toString|Function __toString
Get Entity Data as Json, without the propreties defined in the array property $protecteds|
|all|Function all
Find all entities|
|allToArray|Function all
Find all entities, and return a array or null|
|delete|Function delete
Remove data of this entity of database|
|find|Function find
Find a entity by id|
|findBy|Function findBy
Find all entities by any column match|
|findOneBy|Function findOneBy
Find a entity by any column match|
|getCreated|Function getCreated
Return entity created timestamp|
|getId|Function getId
Return entity ID (unique on system identification)|
|getManager|Function getManager
Get a instance of Doctrine ORM EntityManager an return this, or null|
|getUpdated|Function getUpdated
Return entity updated timestamp|
|save|Function save
Save data of this entity to database, use for create or update entities|
|setCreated|Function setCreated
Set entity creation timestamp|
|setUpdated|Function setUpdated
Set entity updated timestamp|



### Auth::checkPass  

**Description**

```php
public checkPass (string $passKey)
```

Function checkPass
Check Auth password key 

 

**Parameters**

* `(string) $passKey`

**Return Values**

`bool`




<hr />


### Auth::getEmail  

**Description**

```php
public getEmail (void)
```

Function getEmail
Get Auth email 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`




<hr />


### Auth::getRole  

**Description**

```php
public getRole (void)
```

Function getRole
Get role permission ID 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`int`




<hr />


### Auth::getRoleName  

**Description**

```php
public getRoleName (void)
```

Function getRoleName
Get role permission Name 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`




<hr />


### Auth::getUser  

**Description**

```php
public static getUser (string $token)
```

Function getUser
Get a Auth User by token and appKey 

 

**Parameters**

* `(string) $token`

**Return Values**

`\Auth|null`




<hr />


### Auth::getUsername  

**Description**

```php
public getUsername (void)
```

Function getUsername
Get Auth username 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`




<hr />


### Auth::login  

**Description**

```php
public static login (string $username, string $passKey, string $appKey, string $expiration, string $nobefore)
```

Function function
Check  Auth User and return a string token of on success or null in error case 

 

**Parameters**

* `(string) $username`
: - Auth username  
* `(string) $passKey`
: - Auth password key  
* `(string) $appKey`
: - Basicis AppKey  
* `(string) $expiration`
: - Expires at specified monent  
* `(string) $nobefore`
: - No use Before of this moment  

**Return Values**

`string|null`




<hr />


### Auth::setEmail  

**Description**

```php
public setEmail (string $email)
```

Function setEmail
Set Auth email 

 

**Parameters**

* `(string) $email`

**Return Values**

`\Auth`




<hr />


### Auth::setPass  

**Description**

```php
public setPass (string $passKey)
```

Function setPass
Set Auth password key 

 

**Parameters**

* `(string) $passKey`

**Return Values**

`\Auth`




<hr />


### Auth::setRole  

**Description**

```php
public setRole (int $roleId)
```

Function setRole
Set role permission ID includes is Default roles permissions IDs 'DEFAULT_ROLES' or optional > 5 

 

**Parameters**

* `(int) $roleId`

**Return Values**

`\Auth`




<hr />


### Auth::setUsername  

**Description**

```php
public setUsername (string $username)
```

Function setUsername
Set Auth username 

 

**Parameters**

* `(string) $username`

**Return Values**

`\Auth`




<hr />

