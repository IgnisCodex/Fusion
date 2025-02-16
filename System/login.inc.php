<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    include "dbh.class.php";
    include "user.class.php";
    include "login-contr.class.php";

    $contr = new LoginController($email, $password);
    $contr->login();
    header("location: /chat/@me");

} else {
    // Invalid Request Redirection
    header("location: /login?error=invalid_request");
}