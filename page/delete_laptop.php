<?php
require_once '../classes/dbh.classes.php';

if (isset($_POST['AssetTag']) && is_array($_POST['AssetTag'])) {
    $assetTags = $_POST['AssetTag'];

    if (count($assetTags) > 0) {
        $db = new Dbh();
        $conn = $db->conn;

        // Prepare placeholders for AssetTags
        $placeholders = implode(',', array_fill(0, count($assetTags), '?'));

        // SQL to delete the selected assets
        $sql = "DELETE FROM laptop WHERE AssetTag IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        // Execute the delete statement
        $stmt->execute($assetTags);

       // Redirect to cat.laptop.php with a success status
       header("Location: cat.laptop.php?status=success");
       exit(); // Ensure no further code is executed after the redirect
   } else {
       echo "No assets selected for deletion.";
   }
} else {
   echo "No valid asset tags provided.";
}
?>
