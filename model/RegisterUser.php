<?php

namespace model;

class RegisterUser
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = htmlspecialchars($username);
        $this->password = htmlspecialchars($password);
    }

    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }

}