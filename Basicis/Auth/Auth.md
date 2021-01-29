# Basicis\Auth\Auth  

Auth Class
Basicis default authentication class





## Methods

| Name | Description |
|------|-------------|
|[getUser](#authgetuser)|Function getUser
Get a Auth User by ServerRequestInterface|
|[login](#authlogin)|Function function
Check  Auth User and return a string token of on success or null in error case|




### Auth::getUser  

**Description**

```php
public static getUser (\ServerRequestInterface $request, string|null $authClass)
```

Function getUser
Get a Auth User by ServerRequestInterface 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(string|null) $authClass`

**Return Values**

`\AuthInterface|null`




<hr />


### Auth::login  

**Description**

```php
public static login (\ServerRequestInterface $request, array $findBy, string $passKey, string $appKey, string $expiration, string $nobefore)
```

Function function
Check  Auth User and return a string token of on success or null in error case 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(array) $findBy`
: - Array find user by arguments  
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

