# Basicis\Core\Log  

Log Class
Describes a logger instance.

The message MUST be a string or object implementing __toString().

The message MAY contain placeholders in the form: {foo} where foo
will be replaced by the context data in key "foo".
The context array can contain arbitrary data, the only assumption that
can be made by implementors is that if an Exception instance is given
to produce a stack trace, it MUST be in a key named "exception".
See https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
for the full interface specification.  

## Implements:
Psr\Log\LoggerInterface



## Methods

| Name | Description |
|------|-------------|
|[__construct](#log__construct)|Function __construct|
|[alert](#logalert)|Function alert
Action must be taken immediately.|
|[critical](#logcritical)|Function critical
Critical conditions.|
|[debug](#logdebug)|Funtion debug
Detailed debug information|
|[emergency](#logemergency)|Function emergency
System is unusable.|
|[error](#logerror)|Function error
Runtime errors that do not require immediate action but should typically be logged and monitored.|
|[formatMessage](#logformatmessage)|Function formatMessage
Format Message to file log line|
|[formatMessageToArray](#logformatmessagetoarray)|Function formatMessageToArray
Format Message line, and return this as array|
|[getByDate](#loggetbydate)|Function getByDate
Get a log file by string date and return a array with contents|
|[info](#loginfo)|Function info
Interesting events.|
|[interpolate](#loginterpolate)|Function interpolate
Interpolates context values into the message placeholders.|
|[log](#loglog)|Function log
Logs with an arbitrary level.|
|[notice](#lognotice)|Function notice
Normal but significant events|
|[warning](#logwarning)|Function warning
Exceptional occurrences that are not errors.|




### Log::__construct  

**Description**

```php
public __construct (string $path, string $email)
```

Function __construct 

 

**Parameters**

* `(string) $path`
: Path to root log directory  
* `(string) $email`
: Email address for send log, default = null.  

**Return Values**

`void`




<hr />


### Log::alert  

**Description**

```php
public alert (string $message, array $context)
```

Function alert
Action must be taken immediately. 

- Ex: Entire website down, database unavailable, etc. This should  
trigger the SMS alerts and wake you up. 

**Parameters**

* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`void`




<hr />


### Log::critical  

**Description**

```php
public critical (string $message, array $context)
```

Function critical
Critical conditions. 

- Ex: Application component unavailable, unexpected exception. 

**Parameters**

* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`void`




<hr />


### Log::debug  

**Description**

```php
public debug (string $message, array $context)
```

Funtion debug
Detailed debug information 

 

**Parameters**

* `(string) $message`
: - Text message  
* `(array) $context`
: - Array with context values  

**Return Values**

`void`




<hr />


### Log::emergency  

**Description**

```php
public emergency (string $message, array $context)
```

Function emergency
System is unusable. 

 

**Parameters**

* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`void`




<hr />


### Log::error  

**Description**

```php
public error (string $message, array $context)
```

Function error
Runtime errors that do not require immediate action but should typically be logged and monitored. 

 

**Parameters**

* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`void`




<hr />


### Log::formatMessage  

**Description**

```php
public formatMessage (string $level, string $message, string $date_format, string $format)
```

Function formatMessage
Format Message to file log line 

 

**Parameters**

* `(string) $level`
: Log level  
* `(string) $message`
: Text message  
* `(string) $date_format`
: Default format "Y/m/d H:i:s"  
* `(string) $format`
: Default line message format "{date} \| {message}"  

**Return Values**

`string`




<hr />


### Log::formatMessageToArray  

**Description**

```php
public formatMessageToArray (string $level, string $message, string $date_format)
```

Function formatMessageToArray
Format Message line, and return this as array 

- Ex:  
  
```php  
[  
  "date" => Y/m/d H:i:s,  
  "level" => "Level",  
  "message" => "Text Message interpolated.",  
  "context" => array()  
];  
``` 

**Parameters**

* `(string) $level`
: Log level  
* `(string) $message`
: Text message  
* `(string) $date_format`
: Default format "Y/m/d H:i:s"  

**Return Values**

`string`




<hr />


### Log::getByDate  

**Description**

```php
public getByDate (string $date)
```

Function getByDate
Get a log file by string date and return a array with contents 

 

**Parameters**

* `(string) $date`

**Return Values**

`array|null`




<hr />


### Log::info  

**Description**

```php
public info (string $message, array $context)
```

Function info
Interesting events. 

- Ex: User logs in, SQL logs. 

**Parameters**

* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`void`




<hr />


### Log::interpolate  

**Description**

```php
public interpolate (string $message, array $context)
```

Function interpolate
Interpolates context values into the message placeholders. 

 

**Parameters**

* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`string`




<hr />


### Log::log  

**Description**

```php
public log (mixed $level, string $message, array $context)
```

Function log
Logs with an arbitrary level. 

 

**Parameters**

* `(mixed) $level`
: "emergency", "alert", "critical", "error", "warning", "notice", "info" or "debug"  
* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`void`




<hr />


### Log::notice  

**Description**

```php
public notice (string $message, array $context)
```

Function notice
Normal but significant events 

 

**Parameters**

* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`void`




<hr />


### Log::warning  

**Description**

```php
public warning (string $message, array $context)
```

Function warning
Exceptional occurrences that are not errors. 

- Ex: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong. 

**Parameters**

* `(string) $message`
: Text message  
* `(array) $context`
: Array with context values  

**Return Values**

`void`




<hr />

