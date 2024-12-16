<?php
session_start();
$_SESSION["useremail"] = $email;

class Login extends Dbh {

    protected function getUser($email, $pwd){
        $stmt = $this->connect()->prepare('SELECT users_uid, users_pwd FROM users WHERE users_email = ?;');

        if (!$stmt->execute([$email])) {
            $stmt = null; // Delete statement
            $_SESSION['error'] = "Database error: Failed to execute query.";
            header("location: ../index.php");
            exit();
        }

        // Fetch both user ID and password hash
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            $stmt = null;
            $_SESSION['error'] = "User not found. Please check your email.";
            header("location: ../index.php");
            exit();
        }

        // Verify password
        $checkPwd = password_verify($pwd, $userData["users_pwd"]);

        if (!$checkPwd) {
            $stmt = null;
            $_SESSION['error'] = "Incorrect password. Please try again.";
            header("location: ../index.php");
            exit();
        }

        // Set session variables
        session_start();
        $_SESSION["userid"] = $userData["users_id"];
        $_SESSION["useremail"] = $email;

        $stmt = null;
    }
}
