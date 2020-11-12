<?php

namespace App\Model;

use App\Validator\Validator;

/**
 * Class BaseModel
 * @package App\Model
 * Nakoľko v tomto prípade neukladáme model do databázy (zatiaľ :-)) a tým pádom nepotrebujeme anotácie pre migráciu,
 * tak som nepoužil klasický symfony Entity, ale vyrobil si veľmi primitívny model pre prácu s dátami - inšpirovaný Yii2/Laravel
 * Oni však následne aj overridujú magické metódy __set/__get.
 */
abstract class BaseModel
{
    private $attributes = ['id' => null];
    public $id;
    protected $error = [];

    /**
     * BaseModel constructor.
     * Vytvorí si "properties" pre neskoršie operácie, ako je napr. load dát, alebo validácia.
     */
    public function __construct()
    {
        foreach ($this->rules() as $rule) {
            foreach ($rule[0] as $attribute) {
                if (empty($params[$attribute])) {
                    $this->attributes[$attribute] = null;
                    $this->{$attribute} = null;
                }
            }
        }
    }

    /**
     * @return array
     */
    abstract function rules(): array;

    /**
     * @param array $data
     * @return bool
     */
    public function load(array $data): bool
    {
        foreach ($this->attributes as $key => $value) {
            if (isset($data[$key])) {
                $this->{$key} = $data[$key];
            }
        }

        return true;
    }

    /**
     * TODO - Validácia dát, prípadne ich úprava pred uložením (napr. do databázy, alebo pri requeste na update voči API).
     */
    public function validate(): bool
    {
        $validator = new Validator();
        foreach ($this->rules() as $rule) {
            foreach ($rule[0] as $attribute) {
                if (!$validator->validate($attribute, $this->{$attribute}, $rule[1])) {
                    $this->error[] = $validator->error();
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * TODO - Následná práca s ORM, v zadaní to nebolo :)
     * @param bool $validate
     * @return bool
     */
    public function save($validate = true): bool
    {
        if ($this->validate() || !$validate) {
            //ORM save
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getError(): ?array
    {
        return $this->error;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->{$name} = $value;
        if(!empty($this->attributes[$name])) {
            $this->attributes[$name] = $value;
        }
    }
}