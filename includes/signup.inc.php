<?php

if(isset($_POST["submit"]))
{
    // grabbing data
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];


    // Instantiate SignupContr class
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";
    $signup = new SignupContr($pwd, $pwdRepeat, $email);


    // Running error handlers and user signup
    $signup->signupUser(); 

    // Going to back to the front page
    header("location: ../index.php?error=none(signup)");
}