<?php

session_start();

if (isset($_SESSION['user'])) {

    $id = $_SESSION['user']['id'];
    
    include "dbh.class.php";
    include "user.class.php";
    include "logout-contr.class.php";

    $contr = new LogoutController($id);
    $contr->logout();

    header("location: /login?error=none");
} else {
    header("location: /login?error=not_logged_in");
    exit();
}