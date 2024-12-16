<?php
session_start();  // Start the session

// Destroy all session data to log the user out
session_unset();
session_destroy();

// Redirect to the login page or home page
header("Location: ../index.php");
exit();
?>
