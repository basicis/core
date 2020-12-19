# Basicis\Auth\Token  

Token Class
Basicis default Token class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#token__construct)|Function __construct
Defining a new instance de Token|
|[check](#tokencheck)|Function check
Checking a token|
|[create](#tokencreate)|Function create
Receive an instance of AuthInterface user and Creating a token|
|[decode](#tokendecode)|Function Decode Token
Deconding a token|
|[encode](#tokenencode)|Function Encode Token
Enconding a Token|
|[renew](#tokenrenew)|Function renew
Renew a Token, optionaly set any data type of string, array or null|




### Token::__construct  

**Description**

```php
public __construct (\AuthInterface $user, string $appKey, string $expiration, string $nobefore)
```

Function __construct
Defining a new instance de Token 

 

**Parameters**

* `(\AuthInterface) $user`
* `(string) $appKey`
* `(string) $expiration`
* `(string) $nobefore`

**Return Values**

`void`




<hr />


### Token::check  

**Description**

```php
public check (string $token)
```

Function check
Checking a token 

 

**Parameters**

* `(string) $token`

**Return Values**

`bool`




<hr />


### Token::create  

**Description**

```php
public create (\AuthInterface $user, array|string|null $data)
```

Function create
Receive an instance of AuthInterface user and Creating a token 

 

**Parameters**

* `(\AuthInterface) $user`
* `(array|string|null) $data`

**Return Values**

`string|null`




<hr />


### Token::decode  

**Description**

```php
public decode (string $token)
```

Function Decode Token
Deconding a token 

 

**Parameters**

* `(string) $token`

**Return Values**

`object|null`




**Throws Exceptions**


`\Exception`


<hr />


### Token::encode  

**Description**

```php
public encode (array $token)
```

Function Encode Token
Enconding a Token 

 

**Parameters**

* `(array) $token`

**Return Values**

`string`




<hr />


### Token::renew  

**Description**

```php
public renew (string $token, string $expiration, string $nobefore, string|array|null $data)
```

Function renew
Renew a Token, optionaly set any data type of string, array or null 

 

**Parameters**

* `(string) $token`
* `(string) $expiration`
* `(string) $nobefore`
: Parse about any English textual datetime description into a Unix timestamp  
https://www.php.net/manual/en/function.strtotime  
* `(string|array|null) $data`

**Return Values**

`string|null`




<hr />

