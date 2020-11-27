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
     * Function __construct
     *
     * @return void
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
     * Function setCreated.
     *
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
     *
     * @return \DateTime
     */
    public function getCreated() : \DateTime
    {
        return $this->created;
    }


    /**
     * Function setUpdated
     *
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
        $dataBase->setORMConfig(
            [
                App::path()."src/",
                App::path()."src/models/",
                App::path()."src/model/"
            ],
            App::getEnv("APP_ENV") ?? true
        )->setDBConfig(
            App::getEnv("DB_USER") ?? 'basicis',
            App::getEnv("DB_PASS") ?? 'basicis',
            App::getEnv("DB_NAME") ?? 'basicis',
            App::getEnv("DB_HOST") ?? 'localhost',
            (int) App::getEnv("DB_PORT") ?? 3306,
            App::getEnv("DB_DRIVER") ?? "pdo_mysql",
            App::getEnv("DB_PATH") ?? null //For sqlite
        );
        

        return $dataBase->getManager();
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
        return self::getManager()->getRepository(get_called_class())->findBy($findBy);
    }


    /**
     * Function findOneBy
     *
     * @param array $findOneBy
     * @return Model|null
     */
    public static function findOneBy(array $findOneBy = []) :? Model
    {
        return self::getManager()->getRepository(get_called_class())->findOneBy($findOneBy);
    }


    /**
     * Function find
     *
     * @param array $id
     * @return Model|null
     */
    public static function find(int $id) : ?Model
    {
        return self::getManager()->find(get_called_class(), $id);
    }


    /**
     * Function all
     *
     * @return array|null
     */
    public static function all() : ?array
    {
        return self::getManager()->getRepository(get_called_class())->findAll();
    }
}
