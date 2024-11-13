<?php

namespace App\Forms\UserForm;

class RegisterForm
{
    private string $name;
    private string $email;
    private string $password;
    private string $password_confirmation;

    public function setFields(string $name, string $email, string $password, string $password_confirmation): void
    {
        $this->name = $name;
        $this->email= $email;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
    }

    public function validFields(): bool
    {
        if (strlen($this->name) < 3) {
            return false;
        }

        return true;
    }
}