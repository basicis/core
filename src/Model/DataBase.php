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
     * @param int|string $port
     * @param string $driver
     * @param string $path
     * @return void
     */
    public function setDBConfig(
        string $user = null,
        string $pass = null,
        string $dbname = null,
        string $host = null,
        $port = 3306,
        string $driver = "pdo_mysql",
        string $path = ""
    ) {
        $this->config["db"] = [
            'driver' => $driver,
            'host' => $host ,
            'port' => (int) $port,
            'user'     => $user,
            'password' => $pass,
            'dbname'   => $dbname,
            'path' => $path
        ];
        return $this;
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

    private function extractUrlParams(string $url) : array
    {
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => '',
            'password' => '',
            'dbname'   => '',
            'host' => 'localhost',
            'port' => 3306
        );

        $dbParams['driver'] = explode("://", $url)[0];
        $url = explode("://", $url)[1];

        $dbParams['user'] = explode(":", explode($url, "@")[0])[0];
        $dbParams['pass'] = explode(":", explode($url, "@")[0])[1];
        $url = explode("@", $url)[1];

        if (count(explode(":", $url)) === 1) {
            $dbParams['host'] = explode("/", $url);
        } 

        if (count(explode(":", $url)) === 2) {
            $dbParams['host'] = explode(":", explode("/", $url)[0]);
            $dbParams['port'] = (int) explode(":", explode("/", $url)[0]);
        } 
        $dbParams['dbname'] = explode("/", $url)[1];
        return $dbParams;
    }

     /**
     * Function setDBConfig2
     *
     * @param array $options = ["driver" => null,"url" => null, "path" => null]
     * @return void
     */
    public function setDBConfig2(array $options = ["driver" => null,"url" => null, "path" => null])
    {
        $this->config["db"] = [
            'driver' => $options['driver'] ?? "pdo_sqlite",
        ];

        if (isset($options['url']) && $this->isUrl($options['url'])) {
            $this->config['db'] = array_merge($this->config['db'], $this->extractUrlParams($options['url']));
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
