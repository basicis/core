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
     * Get a instance of Doctrine ORM EntityManager an return this, or null
     * @param string $class
     * @return  EntityManager|null
     */
    public static function getManager() : ?EntityManager
    {
        //To-do change in te future :) by: McGiver Developers
        if(file_exists(App::path()."config/db-config.php")) {
            //Include doctrine db-config
            $dataBase = require App::path()."config/db-config.php";
            if ($dataBase instanceof DataBase) {
                $entityManager = $dataBase->getManager();
                if ($entityManager instanceof EntityManager) {
                    return $entityManager;
                }
            }
        }
        return null;
    }
    

    /**
     * Function save
     * Save data of this entity to database, use for create or update entities
     * @return Bool
     */
    public function save() : Bool
    {
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            $manager->persist($this);

            try {
                $manager->flush();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }


    /**
     * Function delete
     * Remove data of this entity of database
     * @return Bool
     */
    public function delete() : Bool
    {
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            try {
                $manager->remove($manager->merge($this));
                $manager->flush();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }


    /**
     * Function findBy
     * Find all entities by any column match
     * @param array $findBy
     * @return Array|Model[]|null
     */
    public static function findBy(array $findBy = []) : ?Array
    {
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            $entities = $manager->getRepository(get_called_class())->findBy($findBy);
            if (is_array($entities) && (count($entities) > 0)) {
                return $entities;
            }
        }
        return null;
    }


    /**
     * Function findOneBy
     * Find a entity by any column match
     * @param array $findOneBy
     * @return Model|null
     */
    public static function findOneBy(array $findOneBy = []) : ?Model
    {
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            $entityClass = get_called_class();
            $entity = $manager->getRepository($entityClass)->findOneBy($findOneBy);
            if ($entity instanceof $entityClass) {
                return $entity;
            }
        }
        return null;
    }


    /**
     * Function find
     * Find a entity by id
     * @param array $id
     * @return Model|null
     */
    public static function find(int $id) : ?Model
    {
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            $entityClass = get_called_class();
            $entity = $manager->find($entityClass, $id);
            if ($entity instanceof $entityClass) { 
                return $entity;
            }
        }
        return null;
    }


    /**
     * Function all
     * Find all entities
     * @return array|null
     */
    public static function all() : ?array
    {
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            $entities = $manager->getRepository(\get_called_class())->findAll();
            if (is_array($entities) && (count($entities) > 0)) {
                return $entities;
            }
        }
        return null;
    }


    /**
     * Function __toArray
     * Get Entity Data as Array, without the propreties defined in the array property $protecteds
     * @return array
     */
    public function __toArray() : array
    {
        $data = [];
        $props = \array_keys(\get_object_vars($this));
        foreach ($props as  $prop) {
            $method = "get".ucfirst($prop);
            if (method_exists($this, $method) && !in_array($prop, $this->protecteds)) {
                $data[$prop] = $this->$method();
                if ($prop instanceof Model) {
                    $data[$prop] = $this->$prop->__toArray();
                }
            }
        }
        return $data;
    }

    /**
     * Function __toString
     * Get Entity Data as Json, without the propreties defined in the array property $protecteds
     * @return String
     */
    public function __toString() : String
    {
        return json_encode($this->__toArray());
    }
}
