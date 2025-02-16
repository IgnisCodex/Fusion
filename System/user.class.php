<?php

require_once "dbh.inc.php";

class User {
    private $conn; 
    private $mID;

    private $mName;
    private $mUsername;
    private $mEmail;

    private $mPassword;
    private $mPasswordHashed;

    private $mVisibility;           // Online, Offline, Invisible
    private $mStatus;               // Custom Status

    public function __construct($conn, $email, $password, $username = null, $name = null) {
        $this->conn = $conn;
        $this->mEmail = $email;
        $this->mPassword = $password;
        $this->mUsername = $username;
        $this->mName = $name;
    }

    public function Register() {
        // Check if email already exists
        $sql = "SELECT email FROM users WHERE Email = ?";
        $stmt = mysqli_stmt_init($this->conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die("SQL Error");
        }

        mysqli_stmt_bind_param($stmt, "s", $this->mEmail);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            header("location: /register?error=email_taken");
            exit();
        }

        // Hash the password
        $hashedPwd = password_hash($this->mPassword, PASSWORD_DEFAULT);

        // Insert user into the database
        $sql = "INSERT INTO users (Email, Username, Name, Password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($this->conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die("SQL Error");
        }

        mysqli_stmt_bind_param($stmt, "ssss", $this->mEmail, $this->mUsername, $this->mName, $hashedPwd);
        mysqli_stmt_execute($stmt);

        // Redirect to login after successful registration
        header("location: /login?register=success");
        exit();
    }

    public function Authenticate() {
        $sql = "SELECT * FROM users WHERE Email = ?;";
        $stmt = mysqli_stmt_init($this->conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die("SQL Error");
        }

        mysqli_stmt_bind_param($stmt, "s", $this->mEmail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $this->mID = $row['ID'];
            $this->mUsername = $row['Username'];
            $this->mName = $row['Name'];

            $this->mPasswordHashed = $row['Password'];

            // TODO: Add visibility and status
            // $this->mVisibility = $row['Visibility'];
            // $this->mStatus = $row['Status'];

        } else {
            // Email Invalid (eiv)
            header("location: /login?error=eiv");
            exit();
        }

        if (!password_verify($this->mPassword, $this->mPasswordHashed)) {
            // Clear password fields for security
            unset($this->mPassword, $this->mPasswordHashed);
            
            header("location: /login?error=piv");
            exit();
        }

        // Clear password fields for security
        unset($this->mPassword, $this->mPasswordHashed);
    }

    public function Login() {
        
        $this->Authenticate();

        // TODO: Set user to online
        // $this->SetVisability("Online");
        
        session_start();
        $_SESSION["user"] = serialize($this);
        
        header("location: /chat/@me");
        echo "test";
        exit();
        exit();
    }

    public function Logout() {
        session_start();

        // TODO: Set user to offline
        // MAYBE: Does this need to be in here?
        // $this->SetVisability("Offline");

        session_unset();
        session_destroy();
        header("location: /login");
        exit();
    }

    public function getID() {
        return $this->mID;
    }

    public function getName() {
        return $this->mName;
    }

    public function getEmail() {
        return $this->mEmail;
    }

    public function getVisibility() {
        return $this->mVisibility;
    }

    public function getStatus() {
        return $this->mStatus;
    }


}