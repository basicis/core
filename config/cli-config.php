<?php
include_once "./vendor/autoload.php";

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Basicis\Model\DataBase;
use Basicis\Basicis;

Basicis::loadEnv();

$isDevMode = $_ENV['APP_ENV'] !== null ? $_ENV['APP_ENV'] === "dev" : true;
$dataBase = new DataBase([__DIR__ . '/src/Models/'], $isDevMode);

$dataBase->setDBConfig(
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME'],
    $_ENV['DB_HOST'],
    $_ENV['DB_PORT'],
    $_ENV['DB_DRIVER']
);

return ConsoleRunner::createHelperSet($dataBase->getManager());
