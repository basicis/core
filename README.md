<p align="center">
    <a title="Latest stable Version" href="https://packagist.org/packages/basicis/core" >
        <img src="https://poser.pugx.org/basicis/core/version" />
    </a>
    <a title="Total Downloads" href="https://packagist.org/packages/basicis/core" >
        <img src="https://poser.pugx.org/basicis/core/downloads" />
    </a>
    <a title="Dependents" href="https://packagist.org/packages/basicis/core" >
        <img src="https://poser.pugx.org/basicis/core/dependents" />
    </a>
    <a title="MIT license" href="#License" >
        <img src="https://poser.pugx.org/basicis/core/license" />
    </a>
</p>


Basicis is a library open source, which follows as [PSR's - PHP Standards Recommendations](https://www.php-fig.org/psr), focusing on web applications and rest api's.
As the name says, it is made to be basic and direct.

## Get Started

Add library in to you project with Composer
```
composer require basicis/core
```
Or with Git clone
```
git clone http://github.com/basicis/core.git
```

### Bootstrap
```bash
#.env.example
### App Settings ###
APP_ENV="dev"
APP_DESCRIPTION="Basicis Framework"
APP_KEY="APP_KEY_HERE"
APP_TIMEZONE='America/Recife'
#APP_LOG_MAIL="im@example.me"


# For MySQL databases
#DB_DRIVER="pdo_mysql"
DB_HOST="127.0.0.1"
DB_PORT=3306
DB_NAME="dbname"
DB_USER="user"
DB_PASS="userpass"
#DATABASE_URL="${DB_DRIVER}://${DB_USER}:${DB_PASS}@${DB_HOST}:${DB_PORT}/${DB_NAME}"

# For Sqlite database
DB_DRIVER="pdo_sqlite"
DB_PATH="path/to/scheme.db"
```


```php
//config/app-config.php
require_once "../vendor/autoload.php";
use Basicis\Basicis;

/** Loading Enviroment variables */
Basicis::loadEnv();

/**
 * $app variable
 * Create an instance of Basicis\Basicis and setting arguments
 * @var Basicis $app
 */
$app = Basicis::createApp(
    [
      "server" => $_SERVER,
      "files" => $_FILES,
      "cookie" => $_COOKIE,
      //"cache" => true, //defalut false
      /*
      Default token params
      "token" => [
        "iss" => APP_DESCRIPTION | "",
        "expiration" => "+30 minutes",
        "nobefore" => "now",
      ]
      */
    ]
);

/**
 * Setting Controllers definitions
 */
$app->setControllers([
  //Key required for use in direct calls via Basicis App instance
  // Ex: $app->controller("keyContName@method", [object|array|null] $args)
  "home" => "App\\Controllers\\Home",
  "storage" => "App\\Controllers\\Storage",
  "example" => "App\\Controllers\\Example",
  "user" => "App\\Controllers\\User",
  //"App\\Controllers\\Storage",
  //...
]);

/**
 * Setting Middlewares definitions
 */
//Before route middlweares
$app->setBeforeMiddlewares([
  //key no is required
  new App\Middlewares\BeforeExample,
  // new App\Middlewares\Foo
  //...
]);

//Route middlweares
$app->setRouteMiddlewares([
  //only here, key is required
  "example" => new App\Middlewares\Example,
  "development" => new App\Middlewares\Development,
  "guest" => new App\Middlewares\Guest,
  "auth" => new App\Middlewares\Auth,
  //...
]);

//After route middlweares
$app->setAfterMiddlewares([
  //key no is required
  new App\Middlewares\AfterExample
  //new App\Middlewares\Bar
  //...
]);

/**
 * Return the Basicis $app instance created for be imported and run on public/index.php file
 */
return $app;
```

```php
//public/index.php

//Basicis $app configuration and bootstrap
$app = require_once "../config/app-config.php";

//Run Basicis $app
if ($app instanceof Basicis\Basicis) {
    $app->run();
    exit;
}
exit("Error on Start Basicis framework application!");
```

## Documentation
Link to Documentation [here](https://basicis.github.io/core/).

## License
The Basicis Core library is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
