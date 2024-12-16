<?php
require_once '../../classes/dbh.classes.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Dbh();
    $conn = $db->conn;

      // Prepare and bind parameters
      $sql = "INSERT INTO maintenance_records (
        asset_tag, maintenance_type, description, date, status, performed_by, cost,
        next_schedule, spare_parts_used, notes, category, created_at, updated_at
    ) VALUES (
        :asset_tag, :maintenance_type, :description, :date, :status, :performed_by, :cost,
        :next_schedule, :spare_parts_used, :notes, :category, NOW(), NOW()
    )";

    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([
            ':asset_tag' => $_POST['asset_tag'],
            ':maintenance_type' => $_POST['maintenance_type'],
            ':description' => $_POST['description'],
            ':date' => $_POST['date'],
            ':status' => $_POST['status'],
            ':performed_by' => $_POST['performed_by'],
            ':cost' => $_POST['cost'],
            ':next_schedule' => $_POST['next_schedule'],
            ':spare_parts_used' => $_POST['spare_parts_used'],
            ':notes' => $_POST['notes'],
            ':category' => $_POST['category']
        ]);

        // Redirect with success flag
        header("Location: add_mainten.php?success=true");
        exit();
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Asset • IT Asset Management</title>
    <link rel="stylesheet" href="../../css/home.css">
    <link rel="stylesheet" href="../../css/cat.css">
    <link rel="stylesheet" href="../../css/mainten.css">
    <style>
        .form-group {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-field {
            flex: 1 1 220px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .popup button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #0056b3;
        }
    </style>

</head>
<body>
<header>
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 10rem; color: #fff; max-width: 1200px; margin: 0 auto; box-sizing: border-box;">
        <a href="home.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Dashboard</a>
        <a href="asset.php" class="active" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem; background-color: #c0392b;">Assets</a>
        <a href="mainten.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Maintenance</a>
    </nav>
</header>

<main>
    <h3>Add Maintenance Record</h3>

    <form action="add_mainten.php" method="POST">
        <div class="form-group">
            <div class="form-field">
                <label for="asset_tag">Asset Tag:</label>
                <input type="text" id="asset_tag" name="asset_tag" required>
            </div>

            <div class="form-field">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="Laptop">Laptop</option>
                <option value="PC">PC</option>
                <option value="UPS">UPS</option>
                <option value="Router">Router</option>
            </select>
        </div>

            <div class="form-field">
                <label for="maintenance_type">Maintenance Type:</label>
                <input type="text" id="maintenance_type" name="maintenance_type" required>
            </div>
        </div>

        <div class="form-group">
            <div class="form-field">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="3" required></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="form-field">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-field">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
        </div>

        <div class="form-group">
        <div class="form-field">
    <label for="performed_by">Performed By:</label>
    <select id="performed_by" name="performed_by">
        <option value="technician_1">Technician 1</option>
        <option value="technician_2">Technician 2</option>
        <option value="technician_3">Technician 3</option>
    </select>
</div>

            <div class="form-field">
                <label for="cost">Cost:</label>
                <input type="number" id="cost" name="cost" step="0.01">
            </div>
        </div>

        <div class="form-group">
            <div class="form-field">
                <label for="next_schedule">Next Schedule:</label>
                <input type="date" id="next_schedule" name="next_schedule">
            </div>
            <div class="form-field">
                <label for="spare_parts_used">Spare Parts Used:</label>
                <textarea id="spare_parts_used" name="spare_parts_used" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="form-field">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" rows="3"></textarea>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit">Add Record</button>
            <button type="button" onclick="cancelAdding()">Cancel</button>
        </div>
    </form>
</main>

<div id="successPopup" class="popup">
    <div class="popup-content">
        <h4>Maintenance Record Added Successfully!</h4>
        <button onclick="closePopup()">Close</button>
    </div>
</div>

<script>
    // Check if success flag is set in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');

    // Only show the popup if the success flag is true
    if (success === 'true') {
        document.getElementById('successPopup').style.display = 'flex';
    }

    // Function to close the popup and redirect
    function closePopup() {
        window.location.href = '../mainten.php';
    }

    function cancelAdding() {
        window.location.href = '../mainten.php';
    }
</script>

</body>
</html>

