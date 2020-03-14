<?php

namespace App\Models;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validation;

class LoginForm
{
    public $login;
    public $password;
    
    public $isValid = False;
    public $isLoad = False;

    public function __construct($params = [])
    {
        foreach ($params as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                if ($attribute == 'status') {
                    $this->$attribute = (bool)$value;
                } else {
                    $this->$attribute = $value;
                }
            }
        }
    }
    
    public function load($params)
    {
        foreach ($params as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->$attribute = $value;
                $this->isLoad = True;
            }
        }
        return $this->isLoad;
    }
    
    public function validate($users)
    {
        foreach ($users as $user => $password) {
            if ($this->login === $user && $this->password == $password) {
                $this->isValid = True;
            }
        }
        return $this->isValid;
    }
}