# Basicis\Auth\AuthInterface  

AuthInterface, all Auth classes implements from this

## Implements:
Basicis\Model\ModelInterface



## Methods

| Name | Description |
|------|-------------|
|[all](#authinterfaceall)||
|[checkPass](#authinterfacecheckpass)|Function checkPass
Check Auth password key|
|[delete](#authinterfacedelete)||
|[find](#authinterfacefind)||
|[findBy](#authinterfacefindby)||
|[findOneBy](#authinterfacefindoneby)||
|[getCreated](#authinterfacegetcreated)||
|[getEmail](#authinterfacegetemail)|Function getEmail
Return self email|
|[getId](#authinterfacegetid)|Function getId
Return self id|
|[getManager](#authinterfacegetmanager)||
|[getRole](#authinterfacegetrole)|Function getRole
Return self role|
|[getRoleName](#authinterfacegetrolename)|Function getRoleName
Get role permission Name|
|[getUpdated](#authinterfacegetupdated)||
|[getUsername](#authinterfacegetusername)|Function getUsername
Return self username|
|[save](#authinterfacesave)||
|[setCreated](#authinterfacesetcreated)||
|[setEmail](#authinterfacesetemail)|Function setEmail
Return a instance of ModelInterface|
|[setRole](#authinterfacesetrole)|Function setRole
Set role permission ID includes is Default roles permissions IDs 'DEFAULT_ROLES' or optional > 5|
|[setUpdated](#authinterfacesetupdated)||
|[setUsername](#authinterfacesetusername)|Function setUsername
Return a instance of ModelInterface|




### AuthInterface::all  

**Description**

```php
 all (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::checkPass  

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


### AuthInterface::delete  

**Description**

```php
 delete (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::find  

**Description**

```php
 find (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::findBy  

**Description**

```php
 findBy (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::findOneBy  

**Description**

```php
 findOneBy (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::getCreated  

**Description**

```php
 getCreated (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::getEmail  

**Description**

```php
public getEmail (void)
```

Function getEmail
Return self email 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`




<hr />


### AuthInterface::getId  

**Description**

```php
public getId (void)
```

Function getId
Return self id 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`mixed`




<hr />


### AuthInterface::getManager  

**Description**

```php
 getManager (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::getRole  

**Description**

```php
public getRole (void)
```

Function getRole
Return self role 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`int|null`




<hr />


### AuthInterface::getRoleName  

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


### AuthInterface::getUpdated  

**Description**

```php
 getUpdated (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::getUsername  

**Description**

```php
public getUsername (void)
```

Function getUsername
Return self username 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`




<hr />


### AuthInterface::save  

**Description**

```php
 save (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::setCreated  

**Description**

```php
 setCreated (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::setEmail  

**Description**

```php
public setEmail (void)
```

Function setEmail
Return a instance of ModelInterface 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\AuthInterface`




<hr />


### AuthInterface::setRole  

**Description**

```php
public setRole (int $roleId)
```

Function setRole
Set role permission ID includes is Default roles permissions IDs 'DEFAULT_ROLES' or optional > 5 

 

**Parameters**

* `(int) $roleId`

**Return Values**

`\AuthInterface`




<hr />


### AuthInterface::setUpdated  

**Description**

```php
 setUpdated (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AuthInterface::setUsername  

**Description**

```php
public setUsername (void)
```

Function setUsername
Return a instance of ModelInterface 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\AuthInterface`




<hr />

