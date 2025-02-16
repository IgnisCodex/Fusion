<?php

    // name VARCHAR(255) NOT NULL,
    // email VARCHAR(255) NOT NULL,
    // username VARCHAR(255) NOT NULL,
    // password VARCHAR(255) NOT NULL,

    // icon VARCHAR(255) NOT NULL,                                                             -- Path to the icon
    // visibility TINYINT(1) NOT NULL,                                                         -- 0: Offline, 1: Online, 2: Invisable, 3: DND, 4: Idle

class User extends DBH {
    protected function createUser($name, $email, $username, $password) {
        $sql = "INSERT INTO users (name, email, username, password, icon, visibility) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $config = parse_ini_file(__DIR__ . "/../config.ini");
        $icon = $config['user_icon_default'];
        $visibility = 0;
        
        if (!$stmt->execute([$name, $email, $username, $password_hashed, $icon, $visibility])) {
            $stmt = null;
            header("location: /register?error=stmt_failed");
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = $this->connect()->prepare($sql);
        
        if (!$stmt->execute([$email])) {
            $stmt = null;
            header("location: /register?error=stmt_failed");
            exit();
        }

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function loginUser($email, $password) {
        $sql = "SELECT password FROM users WHERE email = ?;";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute([$email])) {
            $stmt = null;
            header("location: /login?error=stmt_failed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: /login?error=invalid_email");
            exit();
        }

        $password_hashed = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['password'];
        $check = password_verify($password, $password_hashed);

        if (!$check) {
            $stmt = null;
            header("location: /login?error=password_incorrect");
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE email = ?;";
            $stmt = $this->connect()->prepare($sql);

            if (!$stmt->execute([$email])) {
                $stmt = null;
                header("location: /login?error=stmt_failed");
                exit();
            }

            if ($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: /login?error=invalid_email");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

            session_start();
            $_SESSION["user"]["id"] = $user['id'];
            $_SESSION["user"]["email"] = $user['email'];
            $_SESSION["user"]["username"] = $user['username'];

            $stmt = null;
            return false;
        }
    }

    // protected function getUser() {
    //     $sql = "SELECT * FROM users WHERE email = ?";
    //     $stmt = $this->connect()->prepare($sql);
        
    //     if (!$stmt->execute([$email])) {
    //         $stmt = null;
    //         header("location: /register?error=stmt_failed");
    //         exit();
    //     }

    //     $result = $stmt->fetch();
    //     $stmt = null;

    //     return $result;
    // }
}