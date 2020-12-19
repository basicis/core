<?php
include_once "./vendor/autoload.php";
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;
use Basicis\Model\DataBase;

//Include db-config
$dataBase = require_once __DIR__."/db-config.php";

if ($dataBase instanceof DataBase) {
    $entityManager = $dataBase->getManager();

    if ($entityManager instanceof EntityManager) {
        //Retrun doctrine orm console
        return ConsoleRunner::createHelperSet($entityManager);
    }
    echo "Erro while loading Doctrine - Entity Manager!\n";
    exit;
}
echo "Erro while loading file".__DIR__."/db-config.php\n";
exit;
