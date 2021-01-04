<?php
namespace Basicis\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Basicis\Model\ModelInteface;
use Basicis\Model\DataBase;
use Basicis\Basicis as App;
use Basicis\Core\Validator;
use Basicis\Core\Annotations;
use Basicis\Core\Log;

/**
 * Model class
 *
 * @ORM\MappedSuperclass
 * @category Basicis
 * @package  Basicis
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Model/Model.php
 */
abstract class Model implements ModelInterface
{

    /**
      * @ORM\Id
      * @ORM\Column(type="integer", unique=true)
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
     * @var array
     */
    protected $protecteds = [];


     /**
      * Function function
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

        $this->setCreated();
        $this->setUpdated();
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
     * Function setCreated
     * Set entity creation timestamp
     * @param string $created
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
     * Set entity updated timestamp
     * @param string $updated
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
     * Function getUpdated
     * Return entity updated timestamp
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
        if (file_exists(App::path()."config/db-config.php")) {
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
     * @return Model
     */
    public function save() : Model
    {
        $modelClass = get_called_class();
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            try {
                $this->setUpdated();
                
                if ($this->getId() === null) {
                    $manager->persist($this);
                }

                if ($this->getId() !== null) {
                    $manager->persist($manager->merge($this));
                }

                $manager->flush();
            } catch (\Exception $e) {
                (new DataBaseException($e->getMessage(), $e->getCode(), $e))->log();
            }
        }
        return $this;
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
                (new DataBaseException($e->getMessage(), $e->getCode(), $e))->log();
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
            try {
                $entities = $manager->getRepository(get_called_class())->findBy($findBy);
            } catch (\Exception $e) {
                (new DataBaseException($e->getMessage(), $e->getCode(), $e))->log();
                return null;
            }
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
            try {
                $entity = $manager->getRepository($entityClass)->findOneBy($findOneBy);
            } catch (\Exception $e) {
                (new DataBaseException($e->getMessage(), $e->getCode(), $e))->log();
                return null;
            }

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
            try {
                $entity = $manager->find($entityClass, $id);
            } catch (\Exception $e) {
                (new DataBaseException($e->getMessage(), $e->getCode(), $e))->log();
                return null;
            }

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
            try {
                $entities = $manager->getRepository(\get_called_class())->findAll();
            } catch (\Exception $e) {
                (new DataBaseException($e->getMessage(), $e->getCode(), $e))->log();
                return null;
            }
            if (is_array($entities) && (count($entities) > 0)) {
                return $entities;
            }
        }
        return null;
    }

    /**
     * Function all
     * Find all entities, and return a array or null
     * @return array|null
     */
    public static function allToArray() : ?array
    {
        $entities = self::all();
        if ($entities !== null) {
            foreach (self::all() as $key => $entity) {
                $entities[$key] = $entity->__toArray();
            }
        }
        return $entities;
    }


    /**
     * Function exists
     * Check if a entity by any column match
     * @param array $findBy
     *
     * @return bool
     */
    public static function exists(array $findBy) : bool
    {
        $model = get_called_class();
        $example = self::findOneBy($findBy);
        if ($example instanceof $model) {
            return true;
        }
        return false;
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
        foreach ($props as $prop) {
            if (!in_array($prop, $this->protecteds) && ($prop !== "protecteds")) {
                $data[$prop] = $this->$prop;
                if ($prop instanceof Model) {
                    $data[$prop] = $this->$prop->__toArray();
                }
            }
        }
        return $data;
    }

    /**
     * Function __toObject
     * Get Entity Data as Object, without the propreties defined in the array property $protecteds
     * @return object
     */
    public function __toObject() : object
    {
        return (object) $this->__toArray();
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

    /**
     * Function getPropertyAnnotation
     * Get a array with property annotations data by prop and tag names, default tag `Column`
     * @param string $name
     * @param string $tag
     *
     * @return array|null
     */
    public static function getPropertyAnnotation(string $name, string $tag = "Column") : ?array
    {
        $prop = (new Annotations(get_called_class()))->getClass()->getProperty($name);
        $tag = "ORM\\$tag";

        if ($prop !== null) {
            $comment = $prop->getDocComment();
            if ($comment !== null) {
                $comment = trim(str_replace(["/**", "*", "/"], "", $comment));
            }

            $returnString = null;
            foreach (explode("@", $comment) as $line) {
                if (str_starts_with($line, $tag)) {
                    $returnString = trim(str_replace([$tag, "(", ")"], "", $line));
                }
            }

            $returnArray = null;
            foreach (explode(",", $returnString) as $key) {
                if (count(explode("=", $key)) === 2) {
                    $tagPropName = explode("=", $key)[0];
                    $tagPropValue = explode("=", $key)[1];
                    $returnArray[trim(str_replace('"', '', $tagPropName))] = trim(str_replace('"', '', $tagPropValue));
                }
            }

            if ($returnArray === null && $returnString !== null) {
                $returnArray = [$returnString];
            }
            return $returnArray;
        }
        return null;
    }
}
