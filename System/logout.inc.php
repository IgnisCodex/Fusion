<?php

session_start();

if (isset($_SESSION["user"])) {

    require_once __DIR__ . "/dbh.inc.php";
    include "user.class.php";

    $user = unserialize($_SESSION["user"]);
    $user->Logout();

} else {
    die("User Not Logged In!");

    // Login Required (lrq)
    header("location: /login?error=lrq");
}