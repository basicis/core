<?php
namespace Basicis\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Basicis\Model\ModelInteface;
use Basicis\Model\DataBase;
use Basicis\Basicis as App;
use Basicis\Core\Validator;
use Basicis\Core\Annotations;
use Basicis\Core\Log;

/**
 * Model class
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
     * $protecteds variable
     * @var array
     */
    protected $protecteds = [];

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
     * Function function
     * @param array|int|null $data
     */
    public function __construct($data = null)
    {
        if (($data !== null) && is_array($data)) {
            foreach ($data as $key => $prop) {
                if (property_exists(get_called_class(), $key)) {
                    $method = 'set'.ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
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
     * Function getProtecteds
     * Get protecteds properties
     * @return array
     */
    public function getProtecteds() : array
    {
        return $this->protecteds;
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
     * Function getTableName
     * Get entity table name
     * @return String
     */
    public static function getTableName() : String
    {
        return self::getManager()->getClassMetadata(get_called_class())->getTableName();
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
    public static function findBy(
        array $findBy = [],
        array $options = array('id' => 'ASC'),
        int $limit = 10,
        int $offset = 0
    ) : ?Array {
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            try {
                $entities = $manager
                            ->getRepository(get_called_class())
                            ->findBy($findBy, $options, $limit, $offset);
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
      * Function paginate
      * Paginate entity search with start offset (0) and total, this is ten (10) by default
      *
      * @param int $limit
      * @param int $offset
      * @param array $protecteds
      *
      * @return array
      */
    public static function paginate(int $limit = 10, int $offset = 0, array $protecteds = []) : array
    {
        $sql = "SELECT * FROM ".self::getTableName()." ORDER BY id LIMIT ".$limit;
        if ($offset > 0) {
            $sql .= " OFFSET ".$offset;
        }
        return self::query($sql, $protecteds);
    }

    /**
      * Function query
      * Execute a sql query string
      *
      * @param string $sql
      * @param array $protecteds
      *
      * @return array|null
      */
    public static function query(string $sql, $protecteds = []) : ?array
    {
        $statement = self::getManager()->getConnection()->prepare($sql);
        $statement->execute();
        return self::removeProtecteds($statement->fetchAll() ?? [], $protecteds);
    }

    /**
     * Function all
     * Find all entities
     * @return array
     */
    public static function all() : array
    {
        $manager = self::getManager();
        if ($manager instanceof EntityManager) {
            try {
                $entities = $manager->getRepository(\get_called_class())->findAll();
            } catch (\Exception $e) {
                (new DataBaseException($e->getMessage(), $e->getCode(), $e))->log();
                return [];
            }
            if (is_array($entities) && (count($entities) > 0)) {
                return $entities;
            }
        }
        return [];
    }

    /**
     * Function all
     * Find all entities, and return a array or null
     * @return array|null
     */
    public static function allToArray() : ?array
    {
        $entities = null;
        try {
            $entities = [];
            foreach (self::all() as $key => $entity) {
                $entities[$key] = $entity->__toArray();
            }
        } catch (\Exception $e) {
            throw $e;
            return null;
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
        $model = self::findOneBy($findBy);
        if ($model !== null) {
            return true;
        }
        return false;
    }

    /**
     * Function removeProtecteds
     * Get Entity Data as Array, without the propreties defined in the array property $protecteds
     * @return array
     */
    public static function removeProtecteds(array $models, array $protecteds = []) : array
    {
        foreach ($models as $i => $model) {
            if (is_array($model)) {
                foreach (array_keys((array) $model) as $key) {
                    if (in_array($key, $protecteds)) {
                        unset($models[$i][$key]);
                    }
                }
            }

            if (is_object($model)) {
                if (in_array($i, $protecteds)) {
                    unset($models[$i]);
                }
            }
        }
        return $models ?? [];
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
            $data[$prop] = $this->$prop;
            if ($prop instanceof Model) {
                $data[$prop] = self::removeProtecteds(
                    $this->$prop->__toArray(),
                    $this->$prop->getProtecteds()
                );
            }
        }
        return self::removeProtecteds($data, $this->getProtecteds()) ?? [];
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
