# Basicis\Cache\CacheItemPool  

CacheItemPool generates CacheItemInterface objects.

The primary purpose of Cache\CacheItemPoolInterface is to accept a key from
the Calling Library and return the associated Cache\CacheItemInterface object.
It is also the primary point of interaction with the entire cache collection.
All configuration and initialization of the Pool is left up to an
Implementing Library.  

## Implements:
Psr\Cache\CacheItemPoolInterface



## Methods

| Name | Description |
|------|-------------|
|[__construct](#cacheitempool__construct)|Function __construct
Receives a cacheFile path as param or null|
|[addItem](#cacheitempooladditem)|Function addItem
Adding a chache item|
|[checkExpiredItems](#cacheitempoolcheckexpireditems)|Function checkExpiredItems
Check if items on is hitable and remove|
|[clear](#cacheitempoolclear)|Function clear
Deletes all items in the pool.|
|[commit](#cacheitempoolcommit)|Function commit
Persists any deferred cache items.|
|[deleteItem](#cacheitempooldeleteitem)|Funtion deleteItem
Removes the item from the pool.|
|[deleteItems](#cacheitempooldeleteitems)|Function deleteItems
Removes multiple items from the pool.|
|[getFile](#cacheitempoolgetfile)|Function getFile
Get this pool file path|
|[getItem](#cacheitempoolgetitem)|Function getItem
Returns a Cache Item representing the specified key.|
|[getItems](#cacheitempoolgetitems)|Function getItems
Returns a traversable set of cache items.|
|[hasItem](#cacheitempoolhasitem)|Function hasItem
Confirms if the cache contains specified cache item.|
|[load](#cacheitempoolload)|Function load
Load a saved cache pool by stream and return this loaded, or return this current object|
|[save](#cacheitempoolsave)|Function save
Persists a cache item immediately.|
|[saveDeferred](#cacheitempoolsavedeferred)|Function saveDeferred
Sets a cache item to be persisted later.|
|[serialize](#cacheitempoolserialize)|Function serialize
Serialize this pool|
|[unserialize](#cacheitempoolunserialize)|Function unserialize
Unserialize this pool|
|[withItem](#cacheitempoolwithitem)|Function withItem
With a Added chache item|




### CacheItemPool::__construct  

**Description**

```php
public __construct (string|null $cacheFile)
```

Function __construct
Receives a cacheFile path as param or null 

 

**Parameters**

* `(string|null) $cacheFile`
: If cacheFile is null, default path is defined the app path  

**Return Values**

`void`


<hr />


### CacheItemPool::addItem  

**Description**

```php
public addItem (string $key, mixed $value, \DateTimeInterface|null $expiration, int|string|\DateIntervalInterface|null $time)
```

Function addItem
Adding a chache item 

 

**Parameters**

* `(string) $key`
* `(mixed) $value`
* `(\DateTimeInterface|null) $expiration`
* `(int|string|\DateIntervalInterface|null) $time`

**Return Values**

`void`


<hr />


### CacheItemPool::checkExpiredItems  

**Description**

```php
public checkExpiredItems (void)
```

Function checkExpiredItems
Check if items on is hitable and remove 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\CacheItemPool`




<hr />


### CacheItemPool::clear  

**Description**

```php
public clear (void)
```

Function clear
Deletes all items in the pool. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

> True if the pool was successfully cleared. False if there was an error.


<hr />


### CacheItemPool::commit  

**Description**

```php
public commit (void)
```

Function commit
Persists any deferred cache items. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

> True if all not-yet-saved items were successfully saved or there were none. False otherwise.


<hr />


### CacheItemPool::deleteItem  

**Description**

```php
public deleteItem (string $key)
```

Funtion deleteItem
Removes the item from the pool. 

 

**Parameters**

* `(string) $key`
: The key to delete.  

**Return Values**

`bool`

> True if the item was successfully removed. False if there was an error.


**Throws Exceptions**


`\InvalidArgumentException`
> If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException  
MUST be thrown.

<hr />


### CacheItemPool::deleteItems  

**Description**

```php
public deleteItems (string[]|array $keys)
```

Function deleteItems
Removes multiple items from the pool. 

 

**Parameters**

* `(string[]|array) $keys`
: An array of keys that should be removed from the pool.  

**Return Values**

`bool`

> True if the items were successfully removed. False if there was an error.


**Throws Exceptions**


`\InvalidArgumentException`
> If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException  
MUST be thrown.

<hr />


### CacheItemPool::getFile  

**Description**

```php
public getFile (void)
```

Function getFile
Get this pool file path 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### CacheItemPool::getItem  

**Description**

```php
public getItem (string $key)
```

Function getItem
Returns a Cache Item representing the specified key. 

This method must always return a CacheItemInterface object, even in case of  
a cache miss. It MUST NOT return null. 

**Parameters**

* `(string) $key`
: The key for which to return the corresponding Cache Item.  

**Return Values**

`\CacheItemInterface`

> The corresponding Cache Item.


**Throws Exceptions**


`\InvalidArgumentException`
> If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException  
MUST be thrown.

<hr />


### CacheItemPool::getItems  

**Description**

```php
public getItems (string[] $keys)
```

Function getItems
Returns a traversable set of cache items. 

 

**Parameters**

* `(string[]) $keys`
: An indexed array of keys of items to retrieve.  

**Return Values**

`array|\Traversable`

> A traversable collection of Cache Items keyed by the cache keys of  
each item. A Cache item will be returned for each key, even if that  
key is not found. However, if no keys are specified then an empty  
traversable MUST be returned instead.


**Throws Exceptions**


`\InvalidArgumentException`
> If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException  
MUST be thrown.

<hr />


### CacheItemPool::hasItem  

**Description**

```php
public hasItem (string $key)
```

Function hasItem
Confirms if the cache contains specified cache item. 

Note: This method MAY avoid retrieving the cached value for performance reasons.  
This could result in a race condition with CacheItemInterface::get(). To avoid  
such situation use CacheItemInterface::isHit() instead. 

**Parameters**

* `(string) $key`
: The key for which to check existence.  

**Return Values**

`bool`

> True if item exists in the cache, false otherwise.


**Throws Exceptions**


`\InvalidArgumentException`
> If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException  
MUST be thrown.

<hr />


### CacheItemPool::load  

**Description**

```php
public load (\CacheItemInterface $item)
```

Function load
Load a saved cache pool by stream and return this loaded, or return this current object 

 

**Parameters**

* `(\CacheItemInterface) $item`
: The cache item to save.  

**Return Values**

`bool`

> True if the item was successfully persisted. False if there was an error.


<hr />


### CacheItemPool::save  

**Description**

```php
public save (\CacheItemInterface $item)
```

Function save
Persists a cache item immediately. 

 

**Parameters**

* `(\CacheItemInterface) $item`
: The cache item to save.  

**Return Values**

`bool`

> True if the item was successfully persisted. False if there was an error.


<hr />


### CacheItemPool::saveDeferred  

**Description**

```php
public saveDeferred (\CacheItemInterface $item)
```

Function saveDeferred
Sets a cache item to be persisted later. 

 

**Parameters**

* `(\CacheItemInterface) $item`
: The cache item to save.  

**Return Values**

`bool`

> False if the item could not be queued or if a commit was attempted and failed. True otherwise.


<hr />


### CacheItemPool::serialize  

**Description**

```php
public serialize (void)
```

Function serialize
Serialize this pool 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### CacheItemPool::unserialize  

**Description**

```php
public unserialize (string $pool)
```

Function unserialize
Unserialize this pool 

 

**Parameters**

* `(string) $pool`

**Return Values**

`\CacheItemPool`




<hr />


### CacheItemPool::withItem  

**Description**

```php
public withItem (string $key, \CacheItemInterface|mixed $value, \DateTimeInterface|null $expiration, int|string|\DateIntervalInterface|null $time)
```

Function withItem
With a Added chache item 

 

**Parameters**

* `(string) $key`
* `(\CacheItemInterface|mixed) $value`
* `(\DateTimeInterface|null) $expiration`
* `(int|string|\DateIntervalInterface|null) $time`

**Return Values**

`void`


<hr />

