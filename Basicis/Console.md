# Basicis\Console  

Basicis\Console class affectionately called Maker

## Get Started:
```
 maker <command> [<option> <option-value> ... ]
```

- Obs: The characters "-" (dash) or "_" (underline) indicate that the following
letter must be capitalized when creating class.

List all controllers files
```
 maker controller -l
```

Create a new controller file named `test`
```
 maker controller -c test
```

Create a new controller alias with command alias `-C`, namespace and model params `model-test`
```
 maker -C -c test -m model-test -n "App\Controllers"
```

Create a new model file
```
 maker model -c ModelTest
```

Create a new model alias with command alias `-M`, namespace and model params
```
 maker -M -c model-test --namesapace "App\Models"
```

### Commands:
| Name | Alias | Description |
|------|-------|-------------|
| help | * | This Help page |
| controller | -C | Remove or List Controllers |
| model | -M | Create, Remove or List Models |
| middleware | -D | Create, Remove or List Middleware |


### Options:
| Name | Alias | Description | Value required |
|------|-------|-------------|----------------|
| -l | | List all classes Controllers, Models or Middlewares | none |
| -c | | Create | classname : string |
| -r | | Remove | classname : string |
| -n | --namesapace | Namespace | namespace : string |
| --class | --name | Class Name | class : string |
| -t | --table | Table name for model command | table : string |
| -m | --model | Model name for controller command | model : string |
| -p | --path | Namespace path | path : string |
| --author.name |  | Author Name | name : string |
| --author.email |  | Author Email | email : string |
| --author.username |  | Author Username | username : string |
| --link |  | File vendor Link | link : string |  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#console__construct)|Function __construct
Construct the console app with a array argument passed or null, to be passed in the `run()` method|
|[exec](#consoleexec)|Function $data["fileType"]
Exec List, create and remove by $data["fileType"]|
|[help](#consolehelp)|Function help
Displays help text|
|[list](#consolelist)|Function list
List files of a specified type|
|[run](#consolerun)|Function run
Run the app console with a past or null argument,
so arguments previously passed in the constructor method will be used|




### Console::__construct  

**Description**

```php
public __construct (array $argv, array $templatePaths)
```

Function __construct
Construct the console app with a array argument passed or null, to be passed in the `run()` method 

 

**Parameters**

* `(array) $argv`
* `(array) $templatePaths`

**Return Values**

`void`


<hr />


### Console::exec  

**Description**

```php
public exec (string $action, array $data)
```

Function $data["fileType"]
Exec List, create and remove by $data["fileType"] 

 

**Parameters**

* `(string) $action`
* `(array) $data`

**Return Values**

`void`




<hr />


### Console::help  

**Description**

```php
public help (void)
```

Function help
Displays help text 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />


### Console::list  

**Description**

```php
public list (string $fileType, string $path)
```

Function list
List files of a specified type 

 

**Parameters**

* `(string) $fileType`
* `(string) $path`

**Return Values**

`void`




<hr />


### Console::run  

**Description**

```php
public run (array $argv)
```

Function run
Run the app console with a past or null argument,
so arguments previously passed in the constructor method will be used 

 

**Parameters**

* `(array) $argv`

**Return Values**

`void`




<hr />

