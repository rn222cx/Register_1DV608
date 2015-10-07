<?php

namespace model;

class RegisterUser
{
    private $username;
    private $password;

    public function __construct($username, $password, $repeatPassword)
    {
        if (mb_strlen($username) < 3 && mb_strlen($password) < 6)
            throw new \NameAndPasswordLengthException();
        if (mb_strlen($username) < 3)
            throw new \UsernameLengthException();
        if (mb_strlen($password) < 6)
            throw new \PasswordLengthException();
        if ($password != $repeatPassword)
            throw new \PasswordDoesntMatchException();
        if (filter_var($username, FILTER_SANITIZE_STRING) !== $username)
            throw new \UsernameInvalidCharactersException();


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