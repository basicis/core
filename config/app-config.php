<?php
/**
 * Bootstrap Basicis App
 * PHP version 7
 *
 * - Create Basicis App and setting arguments
 * - Setting Controllers definitions
 * - Setting Middlewares definitions
 * - Setting view filters, for html template view
 * - And finally, Return the Basicis $app instance created for be imported and run on public/index.php file
 *
 * @category Basicis/Core
 * @package  Basicis/Core
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core
 */

require_once "../vendor/autoload.php";
use Basicis\Basicis;
use Basicis\Http\Message\Uri;
use Basicis\Http\Message\ServerRequestFactory;

/** Loading Enviroment variables */
Basicis::loadEnv();

/** Create a symlink default from storage/assets to public/ as assets */
Basicis::createSymLink();

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
// Before route middlweares
$app->setBeforeMiddlewares([
  //key no is required
  new App\Middlewares\BeforeExample,
  // new App\Middlewares\Foo
  //...
]);

// Route middlweares
$app->setRouteMiddlewares([
  //only here, key is required
  "example" => new App\Middlewares\Example,
  "development" => new App\Middlewares\Development,
  "guest" => new App\Middlewares\Guest,
  "auth" => new App\Middlewares\Auth,
  //...
]);

// After route middlweares
$app->setAfterMiddlewares([
  //key no is required
  new App\Middlewares\AfterExample
  //new App\Middlewares\Bar
  //...
]);


/**
 * Setting view filters, for html template view
 */
$app->setViewFilters([
  //here, key is required
  "isTrue" => function ($value = true) {
    return $value;
  },
  "isInt" => function ($value) {
    return $value > 0;
  },
  "isText" => function ($value) {
    return is_string($value) && !is_numeric($value);
  }
  //...
]);


/**
 * Return the Basicis $app instance created for be imported and run on public/index.php file
 */
return $app;
