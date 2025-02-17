<?php

include "user.class.php";

class UserController extends User {
    private $mID;
    private $mPassword;

    public function __construct($id) {
        $this->mID = $id;
    }

    public function get() {
        return $this->getUser($this->mID);
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