<?php
namespace Basicis\Core;

/**
 * Validator Class
 *
 * @category Core
 * @package  Basicis/Core
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Core/Validator.php
 */
class Validator
{
    /**
     * $valid variable
     *
     * @var bool
     */
    public $valid;

    /**
     * $data variable
     *
     * @var mixed
     */
     public $data;

    /**
     * $class variable
     *
     * @var string
     */
    public $class;

    /**
     * $valid variable
     *
     * @var array
     */
    public $errors=[];

    /**
     * Function __construct
     *
     * @param string $class - Classe name with namespace
     */
    public function __construct(string $class = null)
    {
        $this->valid = false;
        $this->class = (!is_null($class) && class_exists($class) )? $class : false;
    }


    /**
     * Function validate
     *
     * @param  string|array $data
     * @param  string|array $validations
     * @param  string       $class
     * @return boolean
     */
    public static function validate($data, $validations, $class = '') : bool
    {
        $validator = new Validator($class);
        if (is_array($data) && is_array($validations)) {
            return $validator->validArray($data, $validations);
        } elseif (is_string((string) $data) && is_string((string) $validations)) {
            return $validator->validString($data, $validations);
        } else {
            return false;
        }
    }

    /**
     * Function validString
     *
     * @param  string $data        - Given to be validated
     * @param  string $validations - All validations
     * @return void
     */
    public function validString(string $data, string $validations)
    {
        $this->data = $data ?? null;
        if (!$this->validArray(['value' => $data], ['value' => $validations])->errors) {
            return true;
        }
        return false;
    }

    /**
     * Function validArray
     *
     * @param  array $data
     * @param  array $validations
     * @return object
     */
    public function validArray(array $data, array $validations) : object
    {
        $datav = null;
        $errors = false;
        $this->data = $data;

        foreach ($validations as $key => $value) {
            foreach (explode('|', $value) as $index => $regex) {
                $regex_key = explode(':', $regex)[0];
                $regex_val = explode(':', $regex)[1] ?? null;
                $datav[$key][$regex_key] = $this->execMethod(
                    $regex_key,
                    [$data[$key], $regex_val, $key]
                );
            }
        }

        foreach ($datav as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if (isset($value2->valid) && !$value2->valid) {
                    $errors[$key] = [];
                    array_push($errors[$key], $value2->error);
                }
            }
        }

        return (object) ['data'=> $data, 'errors' => $errors];
    }

    /**
     * Function execMethod
     *
     * @param  string $method - Method name
     * @param  mixed  $arg    -  Validation argument, array or string
     * @return bool
     */
    public function execMethod(string $method, $arg) : ?object
    {
        $method_explode = explode('_', $method);
        $method = '';
        foreach ($method_explode as $i => $part) {
            if ($i > 0) {
                $method .= ucfirst($part);
                continue;
            }
            $method .= strtolower($part);
        }

        if (method_exists($this, $method)) {
            return (object) $this->$method($arg);
        }
        return null;
    }

    /**
     * Function integer
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function integer($arg) : object
    {
        if (preg_match("/[0-9]/", is_array($arg) ? $arg[0]: $arg)) {
            return (object) ['valid' => true];
        }
        return (object) [
           'valid' => false,
           'error' => 'Not is a valid Integer value!'
        ];
    }

    /**
     * Function int
     * Another alternative to the *integer* function
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function int($arg) : object
    {
        return $this->integer(is_array($arg) ? $arg[0]: $arg);
    }

    /**
     * Function float
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function float($arg) : object
    {
        if (filter_var(is_array($arg) ? $arg[0]: $arg, FILTER_VALIDATE_FLOAT)) {
            return  (object) ['valid' => true];
        }
        return  (object) [
           'valid' => false,
           'error' => 'Not is a valid Float value!'
        ];
    }

    /**
     * Function flt
     * Another alternative to the *float* function
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function flt($arg) : object
    {
        return $this->float(is_array($arg) ? $arg[0]: $arg);
    }

    /**
     * Function string
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function string($arg) : object
    {
        $value = is_array($arg) ? $arg[0] : $arg;
        if (is_string($value) && preg_match("/[a-z-A-Z-_]{1,}/", $value)) {
            return  (object) ['valid' => true];
        }
        return  (object) ['valid' => false, 'error' => 'Not is a valid  String!'];
    }

    /**
     * Function str
     * Another alternative to the *string* function
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function str($arg) : object
    {
        return $this->string(is_array($arg) ? $arg[0]: $arg);
    }

    /**
     * Function url
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function url($arg) : object
    {
        if (filter_var(is_array($arg) ? $arg[0]: $arg, FILTER_VALIDATE_URL)) {
            return (object) ['valid' => true];
        }
        return (object) ['valid' => false, 'error' => 'Not is a valid  Url!'] ;
    }

    /**
     * Function email
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function email($arg) : object
    {
        if (filter_var(is_array($arg) ? $arg[0]: $arg, FILTER_VALIDATE_EMAIL)) {
            return (object) ['valid' => true];
        }
        return  (object) [
            'valid' => false,
            'error' => 'Not is a valid Email address!'
        ];
    }


    /**
     * Function exists
     *
     * @param  array $arg - Validation argument, array [0=> value, 1=> class, 2=> key]
     * @return object
     */
    public function exists(array $arg) : object
    {
        $key = $arg[2];
        $value = $arg[0];

        if ($this->class::findOneBy([$key => $value]) instanceof $this->class) {
            return (object) ['valid' => true] ;
        }
        return (object) [
            'valid' => false,
            'error' => ucfirst($arg[2])." '".$arg[0] ."' no exists in the database !"
        ] ;
    }

    /**
     * Function noexists
     *
     * @param  array $arg - Validation argument, array [0=> value, 1=> class, 2=> key]
     * @return object
     */
    public function noExists(array $arg) : object
    {
        if ($this->exists($arg)->valid == false) {
            return  (object) ['valid' => true];
        }
        return (object) [
            'valid' => false,
            'error' =>  'Value already exists in the database!'
        ] ;
    }

    /**
     * Function minLen
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function minLen($arg) : object
    {
        $value = (int) is_array($arg) ? $arg[0] : $arg ;
        $min = (int) is_array($arg) ? $arg[1] : 1;

        if ($this->str((string) $value)->valid && ( strlen($value) >= $min)) {
            return  (object)  ['valid' => true];
        }
        return (object) [
            'valid' => false,
            'error' =>  'The minimum number of characters is '.$min.'!'
        ];
    }

    /**
     * Function maxlen
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function maxLen($arg) : object
    {
        $value = (int) is_array($arg) ? $arg[0] : $arg ;
        $max = (int) is_array($arg) ? $arg[1] : 256;

        if ($this->str((string) $value)->valid && (strlen($value) <= $max)) {
            return (object) ['valid' => true];
        }
        return (object) [
           'valid' => false,
           'error' =>  'The maximum number of characters is '.$max.'!'
        ];
    }

    /**
     * Function mincount
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function minCount($arg) : object
    {
        $value = (int) is_array($arg) ? $arg[0] : $arg ;
        $min = (int) is_array($arg) ? $arg[1] : 1;

        if ($this->int((int) $value)->valid && ($value >= $min )) {
            return  (object)  ['valid' => true];
        }
        return (object) [
            'valid' => false ,
            'error' =>  'The minimum count must not be less than '.$min.'!'
        ];
    }

    /**
     * Function maxcount
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function maxCount($arg) : object
    {
        $value = (int) is_array($arg) ? $arg[0] : $arg ;
        $max = (int) is_array($arg) ? $arg[1] : 10000000000000000000000000 * 100000;

        if ($this->int((int) $value)->valid && ((int) $value <= (int) $max)) {
            return  (object)  ['valid' => true];
        }
        return (object) [
            'valid' => false ,
            'error' =>  'The maximum value count must not be greater than '.$max.'!'
        ];
    }

    /**
     * Function boolean
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function boolean($arg) : object
    {
        $value = (int) is_array($arg) ? $arg[0] : $arg ;
        if (((string) $value == true) | ((string) $value == false)) {
            return (object) ['valid' => true];
        }
        return (object) [
            'valid' => false,
            'error' =>  'Not is Boolean valid value!'
        ];
    }

    /**
     * Function bool
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function bool($arg) : object
    {
        return $this->boolean($arg);
    }

    /**
     * Function confirmPass
     *
     * @param  array $arg - Validation argument, array or string
     * @return object
     */
    public function confirmPass(array $arg) : object
    {
        $value = isset($this->data[$arg[1]]) ? $this->data[$arg[1]] : '';
        if (($arg[0] == $value) | $this->compareHash([$arg[0], $value])->valid) {
            return (object) ['valid' => true ];
        }
        return (object) [
            'valid' => false,
            'error' => 'Not is a valid confimation value!'
        ];
    }

    /**
     * Function compareHash
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function compareHash(array $arg) : object
    {
        $value = isset($this->data[$arg[1]]) ? $this->data[$arg[1]] : '';
        if (password_verify($arg[0], $value) | password_verify($arg[0], $arg[1])) {
            return (object) ['valid' => true ];
        }
        return (object) [
            'valid' => false,
            'error' => 'Not is a valid confimation value!'
        ];
    }

    /**
     * Function isNull
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function isNull($arg) : object
    {
        if ((is_array($arg) ? $arg[0]: $arg) === null) {
            return (object) ['valid' => true];
        }
        return (object) ['valid' => false, 'error' => 'Not is a Nullable value!' ];
    }

    /**
     * Function noIsNull
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function noIsNull($arg) : object
    {
        if ((is_array($arg) ? $arg[0]: $arg ) !== null) {
            return (object) ['valid' => true];
        }
        return (object) ['valid' => false, 'error' => 'This is a Nullable value!'];
    }

    /**
     * Function startWith
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function startWith($arg) : object
    {
        if (substr(strtolower($arg[0]), 0, strlen($arg[1])) === strtolower($arg[1])) {
            return (object) ['valid' => true];
        }
        return (object) [
            'valid' => false,
            'error' => "Value no starts with '$arg[1]'!"
        ];
    }

    /**
     * Function endWith
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function endWith($arg) : object
    {
        if (substr(strtolower($arg[0]), -abs(strlen($arg[1]))) === strtolower($arg[1])) {
            return (object) ['valid' => true];
        }
        return (object) [
            'valid' => false,
            'error' => "Value no ends with '$arg[1]'!"
        ];
    }
    
    /**
     * Function hasKey
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function hasKey($arg) : object
    {
        if (is_array($arg[0]) && key_exists($arg[1])) {
            return (object) ['valid' => true];
        }
        return (object) [
            'valid' => false,
            'error' => "Value no hasKey '$arg[1]'!"
        ];
    }

    /**
     * Function has
     *
     * @param  mixed $arg - Validation argument, array or string
     * @return object
     */
    public function has($arg) : object
    {
        if (preg_match("^".$arg[0]."^", $arg[1])) {
            return  (object) ['valid' => true];
        }
        return (object) [
           'valid' => false,
           'error' => "Value no has '$arg[1]'!"
        ];
    }
}
