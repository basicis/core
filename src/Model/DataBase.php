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
     * const DEFAULT_DB_PORTS = [
     *   "pdo_mysql" => 3306
     *  ];
     */
    const DEFAULT_DB_PORTS = [
        "pdo_mysql" => 3306
    ];

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



    private function isUrl(string $url)
    {
        return preg_match(
            "/[a-z_]\:\/\/[a-zA-Z0-9.:][a-zA-Z0-9.@][a-zA-Z0-9.:0-9\/a-zA-Z0-9.]/",
            $url
        );
    }

    private function isPath(string $path)
    {
        return preg_match(
            "/[a-zA-Z0-9\/]\.[a-z0-9]/",
            $path
        );
    }


    /**
     *  Function extractUrlParams
     *  Extract url a params to array ans return this
     * @param string $url Database url on format driver://user:pass@host:port/dbname
     * @return array
     */
    public function extractUrlParams(string $url) : array
    {
        $dbParams = [];
        $dbParams['driver'] = explode("://", $url)[0];
        $url = explode("://", $url)[1];

        $dbParams['user'] = explode(":", explode("@", $url)[0])[0];
        if (count(explode(":", explode("@", $url)[0])) === 2) {
            $dbParams['password'] = explode(":", explode("@", $url)[0])[1];
        }
        $url = explode("@", $url)[1];

        $dbParams['host'] = explode(":", explode("/", $url)[0])[0];
        if (count(explode(":", explode("/", $url)[0])) === 2) {
            $dbParams['port'] = explode(":", explode("/", $url)[0])[1];
        } else {
            $dbParams['port'] = self::DEFAULT_DB_PORTS[$dbParams['driver']];
        }
        $url = explode("/", $url)[1];
    
        $dbParams['dbname'] = $url;
        return $dbParams;
    }



    /**
     * Function setDBConfig
     * Set database configurations, driver, url and/or path (for sqlite)
     * @param array $options = ["driver" => null,"url" => null, "path" => null]
     * @return void
     */
    public function setDBConfig(array $options = ["driver" => null,"url" => null, "path" => null])
    {
        $this->config["db"] = [
            'driver' => $options['driver'] ?? "pdo_sqlite",
        ];

        if (isset($options['url']) && $this->isUrl($options['url'])) {
            $this->config['db'] = array_merge($this->config['db'], $this->extractUrlParams($options['url']));
            //To-do review
            //$this->config["db"]['driver'] = $this->extractUrlParams($options['url'])['driver'];
            //$this->config['db']['url'] = $options['url'];
        }
        
        if (isset($options['path']) &&
            $this->isPath($options['path']) &&
            ($this->config["db"]['driver'] === "pdo_sqlite")
        ) {
            $this->config['db']['path'] = $options['path'];
        }
        return $this;
    }


    /**
     * Function setORMConfig
     * Set database orm configurations, a array of entities paths and if is dev mode,
     * for this, default value is true
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
     * Get a instance of Doctrine ORM EntityManager an return this, or null
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
