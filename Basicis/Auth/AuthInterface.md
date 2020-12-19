# Basicis\Auth\AuthInterface  

AuthInterface, all Auth classes implements from this





## Methods

| Name | Description |
|------|-------------|
|[checkPass](#authinterfacecheckpass)|Function checkPass
Check Auth password key|
|[getId](#authinterfacegetid)|Function getId
Return self id|
|[getRole](#authinterfacegetrole)|Function getRole
Return self role|
|[getRoleName](#authinterfacegetrolename)|Function getRoleName
Get role permission Name|
|[getUsername](#authinterfacegetusername)|Function getUsername
Return self username|




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

`int`




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

`string`




<hr />

