<?php

include "user.class.php";

class LogoutController extends User {
    private $mID;
    
    public function __construct($id) {
        $this->mID = $id;
    }

    public function logout() {
        $this->updateSeen($this->mID);

        session_start();
        session_unset();
        session_destroy();
    }
}