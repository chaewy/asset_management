<?php
session_start();
class SignupContr extends Signup {

    private $pwd;
    private $pwdrepeat;
    private $email;

    // Constructor to take user data
    public function __construct($pwd, $pwdRepeat, $email){
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
    }

    // Run the signup process
    public function signupUser(){
        try {
            if($this->emptyInput() == false){
                throw new Exception("All fields are required.");
            }
            if($this->invalidEmail() == false){
                throw new Exception("Invalid email format.");
            }
            if($this->pwdMatch() == false){
                throw new Exception("Passwords do not match.");
            }
            if($this->uidTakenCheck() == false){
                throw new Exception("Email is already registered.");
            }

            $this->setUser($this->pwd, $this->email);
            header("location: ../index.php?success=signup");
            exit();

        } catch (Exception $e) {
            // Redirect with error details
            header("location: ../page/Signup.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    }

    // Check for empty input
    private function emptyInput(){
        return !empty($this->pwd) && !empty($this->pwdRepeat) && !empty($this->email);
    }

    // Validate email address
    private function invalidEmail(){
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Check if passwords match
    private function pwdMatch(){
        return $this->pwd === $this->pwdRepeat;
    }

    // Check if email is taken
    private function uidTakenCheck(){
        return $this->checkUser($this->email);
    }
}
