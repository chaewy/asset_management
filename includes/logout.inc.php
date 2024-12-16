<?php
session_start();
session_unset();
session_destroy();

// Going to back to the front page
header("location: ../php/Home/home.php?error=none=sessionDestroy");