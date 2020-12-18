<?php
use Basicis\Model\DataBase;
use Basicis\Basicis;

Basicis::loadEnv();

$isDevMode = (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === "prod") ? false : true;
$dataBase = new DataBase([Basicis::path()."src/"], $isDevMode);

/*
return $dataBase->setDBConfig(
    $_ENV['DB_USER'] ?? null,
    $_ENV['DB_PASS'] ?? null,
    $_ENV['DB_NAME'] ?? null,
    $_ENV['DB_HOST'] ?? null,
    $_ENV['DB_PORT'] ?? 0,
    $_ENV['DB_DRIVER'] ?? "pdo_sqlite",
    $_ENV['DB_PATH'] ?? "storage/bascis.db"
);
*/

return $dataBase->setORMConfig(
    [Basicis::path()."src/"],
    $isDevMode
)->setDBConfig2(
    [
       "driver" => $_ENV["DB_DRIVER"] ?? "pdo_sqlite",
       "path" => isset($_ENV["DB_PATH"]) ? Basicis::path().$_ENV["DB_PATH"] : Basicis::path()."storage/basicis.db", //For sqlite
       "url" => $_ENV["DATABASE_URL"] ?? null,
    ]
);
