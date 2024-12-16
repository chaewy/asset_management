<?php
// session_start();
// $_SESSION["useremail"] = $email;

class Dbh {

    public $conn;

    public function __construct() {
        $this->conn = $this->connect();
    }

    
    protected function connect(){
        try{
            $username = "root";
            $password = "";
            $dbh = new PDO('mysql:host=localhost;dbname=test', $username, $password);
            return $dbh;
        }
        catch(PDOException $e){
            print "Error! : " . $e->getMessage() . "<br/>";
            die();
        }
    }
}