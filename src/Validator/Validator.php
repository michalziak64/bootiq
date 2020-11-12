<?php
namespace App\Validator;

/**
 * Class Validator
 * @package App\Validator\Validator
 */
class Validator
{
    /**
     * @var $error string
     */
    private $error;

    /**
     * @param $param
     * @param $value
     * @param $type
     * @return bool
     */
    public function validate($param , $value, $type): bool  {
        $this->error = false;
        if(!method_exists($this, $type)) {
            return true;
        }

        return $this->$type($param, $value);
    }

    /**
     * @param $param
     * @param $value
     * @return bool
     */
    public function string($param, $value): bool  {
        if(is_array($value)) {
            $this->error = $param . ' has to be string!';
            return false;
        }

        return true;
    }

    /**
     * @param $param
     * @param $value
     * @return bool
     */
    public function int($param, $value): bool  {
        if(!is_numeric($value)) {
            $this->error = $param . ' has to be integer!';
            return false;
        }

        return true;
    }

    /**
     * @param $param
     * @param $value
     * @return bool
     */
    public function required($param, $value): bool  {
        if(!($value != null && $value != '')) {
            $this->error = $param . ' is required!';
            return false;
        }

        return true;
    }

    public function array($param, $value): bool
    {
        if(!(is_array($value) && $value)) {
            $this->error = $param . ' has to be array!';
            return false;
        }

        return true;
    }

    public function float($param, $value): bool
    {
        if(!(is_float($value) && $value)) {
            $this->error = $param . ' has to be float!';
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function error(): bool  {
        return $this->error;
    }
}