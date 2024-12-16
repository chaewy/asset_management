<?php
header('Content-Type: application/json');

require_once '../classes/dbh.classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['assetTags']) && is_array($input['assetTags'])) {
        $assetTags = $input['assetTags'];

        $db = new Dbh();
        $conn = $db->conn;

        // Prepare the SQL query with placeholders
        $placeholders = implode(',', array_fill(0, count($assetTags), '?'));
        $sql = "SELECT * FROM laptop WHERE AssetTag IN ($placeholders)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($assetTags);

        // Fetch results
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Invalid asset tags provided']);
    }
}
?>
