<?php

if (isset($_POST['username']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    include "dbh.class.php";
    include "user.class.php";
    
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($conn, $email, $password, $username, $name);
    $user->Register();

} else {
    die("Form Data Invalid");

    // Invalid Request Redirection
    header("location: /login?error=fdi");
}