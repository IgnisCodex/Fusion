<?php

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];
    
    include "register-contr.class.php";

    $contr = new RegisterController($name, $email, $username, $password, $passwordRepeat);
    $contr->register();
    header("location: /login?error=none&email=" . $email);

} else {
    // Invalid Request Redirection
    header("location: /register?error=invalid_request");
}