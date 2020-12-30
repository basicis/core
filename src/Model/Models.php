<?php
namespace Basicis\Model;

/**
 * Models class
 *
 * @category Basicis/Model
 * @package  Basicis/Model
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Model/Models.php
 */
class Models
{
    /**
     * $class variable
     *
     * @var string
     */
    private $class;
    
    /**
     * $args variable
     *
     * @var array
     */
    private $args;


    /**
     * Function __construct
     *
     * @param string $class
     * @param array $args
     */
    public function __construct(string $class, array $args = null)
    {
        if (self::isModel($class)) {
            $this->class = $class;
        }
        $this->args = $args;
    }


    /**
     * Function getAll
     * Get all models as objects instance of Basicis\Model\Model
     * @return array|null
     */
    public function getAll() : ?array
    {
        if (self::isModel($this->class)) {
            $class = $this->class;
            if ($this->args === null) {
                return $class::all();
            }
            return $class::findBy($this->args);
        }
    }

    /**
     * Function getAllArray
     * Get all models as array
     * @return array|null
     */
    public function getArray() : ?array
    {
        $all = $this->getAll();
        $allArray = null;

        if ($all !== null) {
            foreach ($all as $item) {
                $allArray[] = $item->__toArray();
            }
        }
        return $allArray;
    }

    /**
     * Function isModel
     * Check if string class name is a model class extends of Basicis\Model\Model
     * @param string $class
     *
     * @return bool
     */
    public static function isModel(string $class) : bool
    {
        return class_exists($class) && get_parent_class($class) === "Basicis\Model\Model";
    }
}
