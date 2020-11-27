<?php
namespace Basicis\Model;

use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;

/**
 *   DataBase Class
 */
class DataBase
{
    /**
     * @var array $config
     */
    private $config = [];


    /**
     * Function __construct
     *
     * @return void
     */
    public function __construct(array $entityPaths = [], $isDevMode = true)
    {
        if ($entityPaths !== []) {
            $this->setORMConfig($entityPaths, $isDevMode);
        }
    }

    /**
     * Function setDBConfig
     *
     * @param string $user
     * @param string $pass
     * @param string $dbname
     * @param string $host
     * @param int $port
     * @param string $driver
     * @param string $path
     * @return void
     */
    public function setDBConfig(
        string $user,
        string $pass,
        string $dbname,
        string $host = "localhost",
        int $port = 3306,
        string $driver = "pdo_mysql",
        string $path = ""
    ) {
        $this->config["db"] = [
            'driver' => $driver,
            'host' => $host ,
            'port' => $port,
            'user'     => $user,
            'password' => $pass,
            'dbname'   => $dbname,
        ];

        if ($driver === 'sqlite') {
            $this->config["db"]['path'] = $path;
        }
        return $this;
    }


    /**
     * Function setORMConfig
     * @param array $entityPaths
     * @param bool $isDevMode
     * @return void
     */
    public function setORMConfig(
        array $entityPaths,
        bool $isDevMode = true
    ) {

        $this->config['orm'] = Setup::createAnnotationMetadataConfiguration(
            $entityPaths, //path to entities
            $isDevMode, //if is dev mode
            null, //
            null, //
            false //
        );
        return $this;
    }

    /**
     * Function getManager
     *
     * @return EntityManager|null
     */
    public function getManager() : ?EntityManager
    {
        if (($this->config['db'] !== null) && ($this->config['orm'] !== null)) {
            return EntityManager::create($this->config['db'], $this->config['orm']);
        }
        return null;
    }
}
