<?php

if (isset($_POST['email']) && isset($_POST['password'])) {
    require_once __DIR__ . "/dbh.inc.php";
    include "user.class.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($conn, $email, $password);
    $user->Login();

} else {
    die("Form Data Invalid");

    // Invalid Request Redirection
    header("location: /login?error=fdi");
}