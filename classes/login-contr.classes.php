<?php
// session_start();
$_SESSION["useremail"] = $email;

class LoginContr extends Login {

    private $email;
    private $pwd;

    // Constructor to take user data
    public function __construct($email, $pwd){
        $this->email = $email;
        $this->pwd = $pwd;
    }

    // Run if error does not occur
    public function loginUser(){
        if ($this->emptyInput() == false) {
            $_SESSION['error'] = "Please fill in all fields!";
            header("location: ../php/Login/login.php");
            exit();
        }

        // Get user data and validate password
        $this->getUser($this->email, $this->pwd);
    }

    // Check if any input is empty
    private function emptyInput() {
        $result;
        if (empty($this->email) || empty($this->pwd)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
