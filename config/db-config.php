<?php
use Basicis\Model\DataBase;
use Basicis\Basicis;

Basicis::loadEnv();

$isDevMode = (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === "prod") ? false : true;

return (new DataBase([Basicis::path()."src/"], $isDevMode))->setDBConfig(
    [
       "driver" => $_ENV["DB_DRIVER"] ?? "pdo_sqlite",
       "path" => isset($_ENV["DB_PATH"]) ? Basicis::path().$_ENV["DB_PATH"] : Basicis::path()."bin/basicis.db", //For sqlite
       "url" => $_ENV["DATABASE_URL"] ?? null,
    ]
);
