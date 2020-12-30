<?php
namespace Basicis\Core;

use \ReflectionClass;
use \ReflectionMethod;

/**
 * Annotations Class
 * Describes a Annotations instance, and works with the comment blocks
 * @category Core
 * @package  Basicis/Core
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Core/Annotations.php
 * @Annotation
 */
class Annotations
{

    /**
     * $class variable
     * @var \ReflectionClass
     */
    private $class;


    /**
     * $method variable
     * @var \ReflectionMethod
     */
    private $method;
    

    /**
     * Function __construct
     * Receives a class as an argument, and works with the comment blocks
     * @param string $class
     */
    public function __construct(string $class, string $method = null)
    {
        if ($class !== null) {
            $this->setClass($class);

            if ($method !== null) {
                $this->setMethod($method);
            }
        }
    }


    /**
     * Function setClass
     * Setting class for extract annotations
     * @param  string $class
     * @return Annotations
     */
    public function setClass(string $class) : Annotations
    {
        if (class_exists($class)) {
            $this->class = new \ReflectionClass($class);
        }
        return $this;
    }


    /**
     * Function getClass
     * Getting a annotations ReflectionClass
     * @return \ReflectionClass|null
     */
    public function getClass() : ?\ReflectionClass
    {
        return $this->class;
    }

    /**
     * Function setMethod
     * Setting a method into a instance of ReflectionClass for extract annotations
     * @param  string $method
     * @return Annotations
     */
    public function setMethod(string $method) : Annotations
    {
        if (method_exists($this->class->name, $method)) {
            $this->method = new \ReflectionMethod($this->class->name, $method);
        }
        return $this;
    }

    /**
     * Function getMethod
     * Getting a annotations ReflectionMethod
     * @return \ReflectionMethod|null
     */
    public function getMethod() : ?\ReflectionMethod
    {
        return $this->method;
    }
    
    /**
     * Function getCommentByTag
     * Get a documentation bloc line by any tag, and return this line
     * @param  string  $method
     * @param  string  $tag
     * @param  integer $index
     * @return string|null
     */
    public function getMethodCommentByTag(string $method, string $tag, int $index = 0) : ?string
    {
        $this->setMethod($method);
        
        if (!empty($tag)) {
            $matches = array();
            $parttern =  "#".$tag.".*#";
            preg_match_all($parttern, $this->getMethod()->getDocComment(), $matches, PREG_PATTERN_ORDER);

            if (isset($matches[0][$index])) {
                return trim($matches[0][$index]);
            }
        }
        return null;
    }

    /**
     * Function getCommentByTag
     * Get a documentation bloc line by any tag, and return this line
     * @param  string  $method
     * @param  string  $tag
     * @param  integer $index
     * @return string|null
     */
    public function getClassCommentByTag(string $tag, int $index = 0) : ?string
    {
        if (!empty($tag)) {
            $matches = array();
            $parttern =  "#".$tag.".*#";
            preg_match_all($parttern, $this->getClass()->getDocComment(), $matches, PREG_PATTERN_ORDER);

            if (isset($matches[0][$index])) {
                return trim($matches[0][$index]);
            }
        }
        return null;
    }
}
