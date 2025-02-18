<?php

include "user.class.php";

class RegisterController extends User {
    private $mName;
    private $mEmail;
    private $mUsername;
    private $mPassword;
    private $mPasswordRepeat;

    public function __construct($name, $email, $username, $password, $passwordRepeat) {
        $this->mName = $name;
        $this->mEmail = $email;
        $this->mUsername = $username;
        $this->mPassword = $password;
        $this->mPasswordRepeat = $passwordRepeat;
    }

    public function register() {
        if ($this->checkUser($this->mEmail)) {
            header("location: /register?error=email_taken");
            exit();
        }

        if ($this->checkPassword($this->mPassword, $this->mPasswordRepeat)) {
            header("location: /register?error=password_mismatch");
            exit();
        }

        $this->createUser($this->mName, $this->mEmail, $this->mUsername, $this->mPassword);
    }

    // Error Handlers
    private function emptyInput($name, $email, $username, $password, $passwordRepeat) {
        if (empty($name) || empty($email) || empty($username) || empty($password) || empty($passwordRepeat)) {
            return true;
        } else {
            return false;
        }
    }

    private function invalidEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    private function checkPassword($password, $passwordRepeat) {
        if ($password !== $passwordRepeat) {
            return true;
        } else {
            return false;
        }
    }
}