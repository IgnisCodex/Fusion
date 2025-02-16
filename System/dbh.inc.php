<?php

$serverAddress = "localhost";
$dbUsername = "root";
$dbPassword = "BnbZ6FQ8eWtgENp7kc3u9m";
$dbName = "fusion";

$conn = mysqli_connect($serverAddress, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}