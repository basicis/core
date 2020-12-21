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

/**
 * $app variable
 * Create an instance of Basicis\Basicis and setting arguments
 * @var Basicis $app
 */

Basicis::loadEnv();
$app = Basicis::createApp(
    //Creating ServerRequest and Uri into this
    ServerRequestFactory::create(
        $_SERVER['REQUEST_METHOD'],
        (new Uri())
            ->withScheme(explode('/', $_SERVER['SERVER_PROTOCOL'])[0] ?? "http")
            ->withHost($_SERVER['HTTP_HOST'] ?? "localhost")
            ->withPort($_SERVER['SERVER_PORT'] ?? null)
            ->withPath($_SERVER['REQUEST_URI'])
    )
    ->withHeaders(getallheaders())
    ->withUploadedFiles($_FILES)
    ->withCookieParams($_COOKIE),
    //Setting app optionals flags
    [
      "appDescription" => $_ENV['APP_DESCRIPTION'],
      "mode" => $_ENV['APP_ENV'],
      "timezone" => $_ENV["APP_TIMEZONE"],
      "appKey" => $_ENV['APP_KEY']
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
  //"App\\Controllers\\Storage",
  //...
]);



/**
 * Setting Middlewares definitions
 */
// Before route middlweares
$app->setBeforeMiddlewares([
  //key no is required
  "App\\Middlewares\\BeforeExample",
  //...
]);

// Route middlweares
$app->setRouteMiddlewares([
  //only here, key is required
  "guest" => "App\\Middlewares\\Guest",
  "auth" => "App\\Middlewares\\Auth",
  "example" => "App\\Middlewares\\Example",
  //...
]);

// After route middlweares
$app->setAfterMiddlewares([
  //key no is required
  "App\\Middlewares\\AfterExample"
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
