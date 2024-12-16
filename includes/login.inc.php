<?php
session_start();

if (isset($_POST["submit"])) {
    // Grabbing data
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];


    $_SESSION['users_email'] = $email; // Store the email after retrieving it
     // Debugging: Check if the email is set correctly in the session
     echo "Session email set: " . htmlspecialchars($_SESSION['users_email']);

    // Instantiate LoginContr class
    include "../classes/dbh.classes.php";
    include "../classes/login.classes.php";
    include "../classes/login-contr.classes.php"; 

    $login = new LoginContr($email, $pwd);

    // Running error handlers and user login
    $login->loginUser(); 

    // Redirect to home if no errors
    header("location: ../page/home.php?error=none");
}
