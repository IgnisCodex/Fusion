<?php

class DBH {
    protected function connect() {
        try {
            $config = parse_ini_file(__DIR__ . "/../config.ini");
            $host = $config['db_host'];
            $username = $config['db_username'];
            $password = $config['db_password'];
            $db = $config['db_name'];

            $conn = new PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $password);

            return $conn;
            
        } catch (PDOException $th) {
            die("Connection Failed: " . $th->getMessage() . "<br>");
        }
    }
}