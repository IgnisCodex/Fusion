<?php

include "user.class.php";

class LoginController extends User {
    private $mEmail;
    private $mPassword;

    public function __construct($email, $password) {
        $this->mEmail = $email;
        $this->mPassword = $password;
    }

    public function login() {
        $this->loginUser($this->mEmail, $this->mPassword);
    }

    // Error Handlers
    private function emptyInput($email, $password, ) {
        if (empty($email) || empty($password)) {
            return true;
        } else {
            return false;
        }
    }
}