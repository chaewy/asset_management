<?php

session_start();

// Include the Dbh class definition
require_once "../classes/dbh.classes.php";

$id = $_SESSION["userid"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uid = $_POST["uid"];
    $email = $_POST["email"];
    $rawPwd = $_POST["pwd"];

    // Hash the raw password
    $hashedPwd = password_hash($rawPwd, PASSWORD_DEFAULT);

    try {
        // Create an instance of the Dbh class to establish a database connection
        $dbh = new Dbh();

        $query = "UPDATE users SET users_uid = :uid, users_pwd = :pwd, users_email = :email WHERE users_id = :id;";

        $stmt = $dbh->conn->prepare($query);

        $stmt->bindValue(":uid", $uid);
        $stmt->bindValue(":pwd", $hashedPwd); // Use the hashed password
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":id", $id);

        $stmt->execute();

        // Close the statement
        $stmt = null;

        header("Location: ../php/Profile/profile.php");

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../php/Profile/profile.php?emptyname=errorNotPost");
}
?>