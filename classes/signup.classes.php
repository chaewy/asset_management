<?php

class Signup extends Dbh {

    // Insert user into the database
    protected function setUser($pwd, $email){
        try {
            $stmt = $this->connect()->prepare('INSERT INTO users (users_pwd, users_email) VALUES (?, ?);');

            // Hash password
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

            // Execute the statement
            if(!$stmt->execute([$hashedPwd, $email])){
                throw new Exception("Failed to insert user into the database.");
            }

        } catch (Exception $e) {
            // Redirect with error details
            header("location: ../page/Signup.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    }

    // Check if the user exists in the database
    protected function checkUser($email){
        try {
            $stmt = $this->connect()->prepare('SELECT users_email FROM users WHERE users_email = ?');

            // Execute the statement
            if(!$stmt->execute([$email])){
                throw new Exception("Failed to check user existence in the database.");
            }

            // Check if the email exists
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? false : true;

        } catch (Exception $e) {
            // Redirect with error details
            header("location: ../page/Signup.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    }
}
