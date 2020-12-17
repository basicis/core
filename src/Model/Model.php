<?php
namespace Basicis\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Basicis\Model\ModelInteface;
use Basicis\Model\DataBase;
use Basicis\Basicis as App;

/**
 *  Model class
 *
 *  @ORM\MappedSuperclass
 */
abstract class Model implements ModelInterface
{

    /**
      * @ORM\Id
      * @ORM\Column(type="integer")
      * @ORM\GeneratedValue
      * @var int $id
      */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @ORM\GeneratedValue
     * @var \DateTime  $created
     *  */
    protected $created;
  
    /**
     * @ORM\Column(type="datetime")
     * @ORM\GeneratedValue
     * @var \DateTime  $updated
     * */
    protected $updated;

    /**
     * $protecteds variable
     *
     * @var array
     */
    protected $protecteds = [];



     /**
      * Function function
      *
      * @param array|int|null $data
      */
    public function __construct($data = null)
    {
        if (($data !== null) && is_array($data)) {
            foreach ($data as $key => $prop) {
                if (property_exists(get_called_class(), $key)) {
                    $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
                    $this->$method($prop);
                }
            }
        }

        if (($data !== null) && is_int($data)) {
            $model = self::find($data);
            if (is_a($model, get_called_class())) {
                return $model;
            }
        }

        if (($data === null)) {
            $this->setCreated();
            $this->setUpdated();
        }
    }


    /**
     * Function getId
     * Return entity ID (unique on system identification)
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }



    /**
     * Function setCreated.
     * Set entity creation timestamp
     * @param string $created
     *
     * @return Model
     */
    public function setCreated(string $created = null) : Model
    {
        if ($created !== null) {
            $this->created = new \DateTime($created);
            return $this;
        }
        $this->created = new \DateTime("now");
        return $this;
    }


    /**
     * Function getCreated
     * Return entity created timestamp
     * @return \DateTime
     */
    public function getCreated() : \DateTime
    {
        return $this->created;
    }


    /**
     * Function setUpdated
     * Return entity updated timestamp
     * @param string $updated
     *
     * @return User
     */
    public function setUpdated(string $updated = null) : Model
    {
        if ($updated !== null) {
            $this->updated = new \DateTime($updated);
            return $this;
        }
        $this->updated = new \DateTime("now");
        return $this;
    }


    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated() : \DateTime
    {
        return $this->updated;
    }


    /**
     * Function getManager
     *
     * @param string $class
     * @return  EntityManager|null
     */
    public static function getManager() : ?EntityManager
    {
        $dataBase = new DataBase();
        return $dataBase->setORMConfig(
            [
                App::path()."src/",
                App::path()."src/models/",
                App::path()."src/model/"
            ],
            $_ENV["APP_ENV"] ?? true
        )->setDBConfig(
            $_ENV["DB_USER"] ?? 'basicis',
            $_ENV["DB_PASS"] ?? 'basicis',
            $_ENV["DB_NAME"] ?? 'basicis',
            $_ENV["DB_HOST"] ?? 'localhost',
            (int) $_ENV["DB_PORT"] ?? 3306,
            $_ENV["DB_DRIVER"] ?? "pdo_mysql",
            $_ENV["DB_PATH"] ?? null //For sqlite
        )->getManager();
    }
    

    /**
     * Function save
     *
     * @return Bool
     */
    public function save() : Bool
    {
        $manager = self::getManager();
        $manager->persist($this);

        try {
            $manager->flush();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }


    /**
     * Function delete
     *
     * @return Bool
     */
    public function delete() : Bool
    {
        $manager = self::getManager();
        try {
            $manager->remove($this);
            $manager->flush();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }


    /**
     * Function findBy
     *
     * @param array $findBy
     * @return Model|null
     */
    public static function findBy(array $findBy = []) : ?Model
    {
        $entity = self::getManager()->getRepository(get_called_class())->findBy($findBy);
        if ($entity) {
            return $entity->getData();
        }
        return null;
    }


    /**
     * Function findOneBy
     *
     * @param array $findOneBy
     * @return Model|null
     */
    public static function findOneBy(array $findOneBy = []) : ?Model
    {
        $entity = self::getManager()->getRepository(get_called_class())->findOneBy($findOneBy);
        if ($entity) { 
            return $entity->getData();
        }
        return null;
    }


    /**
     * Function find
     *
     * @param array $id
     * @return Model|null
     */
    public static function find(int $id) : ?Model
    {
        $entity = self::getManager()->find(get_called_class(), $id);
        if ($entity) {
            return $entity->getData();
        }
        return null;
    }


    /**
     * Function all
     *
     * @return array|null
     */
    public static function all() : ?array
    {
        $entities = self::getManager()->getRepository(\get_called_class())->findAll();
        if ($entities) { 
            $data = [];
            foreach ($entities as $key => $entity) {
                $data[$key] = $entity->getData();
            }
            return $data;
        }
        return null;
    }


    /**
     * Function function
     *
     * @return array
     */
    public function getData() : array
    {
        $data = [];
        $props = \array_keys(\get_object_vars($this));
        foreach ($props as  $prop) {
            $method = "get".ucfirst($prop);
            if (method_exists($this, $method) && !in_array($prop, $this->protecteds)) {
                $data[$prop] = $this->$method();
            }
        }
        return $data;
    }
}
