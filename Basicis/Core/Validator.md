# Basicis\Core\Validator  

Validator Class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#validator__construct)|Function __construct|
|[bool](#validatorbool)|Function bool|
|[boolean](#validatorboolean)|Function boolean|
|[compareHash](#validatorcomparehash)|Function compareHash|
|[confirmPass](#validatorconfirmpass)|Function confirmPass|
|[email](#validatoremail)|Function email|
|[endWith](#validatorendwith)|Function endWith|
|[execMethod](#validatorexecmethod)|Function execMethod|
|[exists](#validatorexists)|Function exists|
|[float](#validatorfloat)|Function float|
|[flt](#validatorflt)|Function flt
Another alternative to the *float* function|
|[has](#validatorhas)|Function has|
|[hasKey](#validatorhaskey)|Function hasKey|
|[int](#validatorint)|Function int
Another alternative to the *integer* function|
|[integer](#validatorinteger)|Function integer|
|[isNull](#validatorisnull)|Function isNull|
|[maxCount](#validatormaxcount)|Function maxcount|
|[maxLen](#validatormaxlen)|Function maxlen|
|[minCount](#validatormincount)|Function mincount|
|[minLen](#validatorminlen)|Function minLen|
|[noExists](#validatornoexists)|Function noexists|
|[noIsNull](#validatornoisnull)|Function noIsNull|
|[startWith](#validatorstartwith)|Function startWith|
|[str](#validatorstr)|Function str
Another alternative to the *string* function|
|[string](#validatorstring)|Function string|
|[url](#validatorurl)|Function url|
|[validArray](#validatorvalidarray)|Function validArray|
|[validString](#validatorvalidstring)|Function validString|
|[validate](#validatorvalidate)|Function validate|




### Validator::__construct  

**Description**

```php
public __construct (string $class)
```

Function __construct 

 

**Parameters**

* `(string) $class`
: - Classe name with namespace  

**Return Values**

`void`


<hr />


### Validator::bool  

**Description**

```php
public bool (mixed $arg)
```

Function bool 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::boolean  

**Description**

```php
public boolean (mixed $arg)
```

Function boolean 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::compareHash  

**Description**

```php
public compareHash (mixed $arg)
```

Function compareHash 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::confirmPass  

**Description**

```php
public confirmPass (array $arg)
```

Function confirmPass 

 

**Parameters**

* `(array) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::email  

**Description**

```php
public email (mixed $arg)
```

Function email 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::endWith  

**Description**

```php
public endWith (mixed $arg)
```

Function endWith 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::execMethod  

**Description**

```php
public execMethod (string $method, mixed $arg)
```

Function execMethod 

 

**Parameters**

* `(string) $method`
: - Method name  
* `(mixed) $arg`
: -  Validation argument, array or string  

**Return Values**

`bool`




<hr />


### Validator::exists  

**Description**

```php
public exists (array $arg)
```

Function exists 

 

**Parameters**

* `(array) $arg`
: - Validation argument, array [0=> value, 1=> class, 2=> key]  

**Return Values**

`object`




<hr />


### Validator::float  

**Description**

```php
public float (mixed $arg)
```

Function float 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::flt  

**Description**

```php
public flt (mixed $arg)
```

Function flt
Another alternative to the *float* function 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::has  

**Description**

```php
public has (mixed $arg)
```

Function has 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::hasKey  

**Description**

```php
public hasKey (mixed $arg)
```

Function hasKey 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::int  

**Description**

```php
public int (mixed $arg)
```

Function int
Another alternative to the *integer* function 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::integer  

**Description**

```php
public integer (mixed $arg)
```

Function integer 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::isNull  

**Description**

```php
public isNull (mixed $arg)
```

Function isNull 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::maxCount  

**Description**

```php
public maxCount (mixed $arg)
```

Function maxcount 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::maxLen  

**Description**

```php
public maxLen (mixed $arg)
```

Function maxlen 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::minCount  

**Description**

```php
public minCount (mixed $arg)
```

Function mincount 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::minLen  

**Description**

```php
public minLen (mixed $arg)
```

Function minLen 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::noExists  

**Description**

```php
public noExists (array $arg)
```

Function noexists 

 

**Parameters**

* `(array) $arg`
: - Validation argument, array [0=> value, 1=> class, 2=> key]  

**Return Values**

`object`




<hr />


### Validator::noIsNull  

**Description**

```php
public noIsNull (mixed $arg)
```

Function noIsNull 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::startWith  

**Description**

```php
public startWith (mixed $arg)
```

Function startWith 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::str  

**Description**

```php
public str (mixed $arg)
```

Function str
Another alternative to the *string* function 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::string  

**Description**

```php
public string (mixed $arg)
```

Function string 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::url  

**Description**

```php
public url (mixed $arg)
```

Function url 

 

**Parameters**

* `(mixed) $arg`
: - Validation argument, array or string  

**Return Values**

`object`




<hr />


### Validator::validArray  

**Description**

```php
public validArray (array $data, array $validations)
```

Function validArray 

 

**Parameters**

* `(array) $data`
* `(array) $validations`

**Return Values**

`object`




<hr />


### Validator::validString  

**Description**

```php
public validString (string $data, string $validations)
```

Function validString 

 

**Parameters**

* `(string) $data`
: - Given to be validated  
* `(string) $validations`
: - All validations  

**Return Values**

`void`




<hr />


### Validator::validate  

**Description**

```php
public static validate (string|array $data, string|array $validations, string $class)
```

Function validate 

 

**Parameters**

* `(string|array) $data`
* `(string|array) $validations`
* `(string) $class`

**Return Values**

`bool`




<hr />

