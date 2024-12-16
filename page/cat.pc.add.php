<?php
require_once '../classes/dbh.classes.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Dbh();
    $conn = $db->conn;

    // Gather form data
    $assetID = $_POST['assetID'];
    $model = $_POST['model'];
    $cpu = $_POST['cpu'];
    $ram = $_POST['ram'];
    $storage = $_POST['storage'];
    $storage_size = $_POST['storage_size'];
    $os = $_POST['os'];
    $serial_no = $_POST['serial_no'];
    $status = $_POST['status'];
    $purchDate = $_POST['purchDate'];
    $warranty = $_POST['warranty'];
    $monitor_id = $_POST['monitor_id'];
    $keyboard_mouse_id = $_POST['keyboard_mouse_id'];
    $user_id = $_POST['user_id'];

    // Prepare the SQL query
    $sql = "INSERT INTO pc (
                assetID, model, cpu, ram, storage, storage_size, os, serial_no, 
                status, purchDate, warranty, monitor_id, keyboard_mouse_id, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    try {
        // Execute the query with bound parameters
        $stmt->execute([
            $assetID, $model, $cpu, $ram, $storage, $storage_size, $os, 
            $serial_no, $status, $purchDate, $warranty, $monitor_id, 
            $keyboard_mouse_id, $user_id
        ]);

        // Redirect with success flag
        header("Location: cat.pc.add.php?success=true");
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
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/cat.css">
    <link rel="stylesheet" href="../css/mainten.css">
    <style>
    .form-group {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 15px;
    }

    .form-field {
    flex: 1 1 220px; /* Ensures each field takes up at least 220px and grows based on available space */
}

    .form-group div {
        flex: 1;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input, .form-group select {
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
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 2rem; color: #fff; max-width: 1200px; margin: 0 auto; box-sizing: border-box;">
        <!-- Empty div to maintain spacing -->
        <div></div>

        <!-- Center navigation links -->
        <div style="display: flex; gap: 20rem; justify-content: center;">
            <a href="home.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Dashboard</a>
            <a href="asset.php" class="active" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem; background-color: #c0392b;">Assets</a>
            <a href="mainten.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem; margin-right: 8rem; ">Maintenance</a>
        </div>

         <!-- Profile icon -->
         <div style="position: relative; margin-left: 10rem; ;">
            <a style="text-decoration: none;" id="profile-icon" onclick="toggleProfilePopup()">
                <img src="../profile.png" alt="Profile" style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid #fff; transition: transform 0.3s; cursor: pointer;">
            </a>
            <!-- Popup container -->
            <div id="profile-popup" style="display: none; position: absolute; top: 40px; right: 0; background-color: #fff; color: #333; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); width: 200px; z-index: 1000;">
                <div style="padding: 1rem;">
                    <p style="margin: 0; font-weight: bold;">Account Info</p>
                    <hr style="margin: 0.5rem 0; border: 0; border-top: 1px solid #ccc;">
                    <p style="margin: 0;">Username: <?php echo htmlspecialchars($username); ?></p>
                    <p style="margin: 0;">Email: <?php echo htmlspecialchars($_SESSION['users_email']); ?></p>
                    <form action="logout.php" method="post">
                        <button type="submit" name="logout" style="background-color: #f44336; color: white; border: none; padding: 8px 16px; margin-top: 1rem; cursor: pointer; border-radius: 5px;">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </nav>
</header>

<script>
    function toggleProfilePopup() {
        const popup = document.getElementById("profile-popup");
        // Toggle display between none and block
        if (popup.style.display === "none" || popup.style.display === "") {
            popup.style.display = "block";
        } else {
            popup.style.display = "none";
        }
    }
    
    // Optional: Hide the popup if clicked outside
    window.onclick = function(event) {
        const popup = document.getElementById("profile-popup");
        const profileIcon = document.getElementById("profile-icon");
        if (event.target !== profileIcon && !profileIcon.contains(event.target)) {
            popup.style.display = "none";
        }
    };
</script>

<main>
    <h3>Add New PC Asset</h3>

    <form action="add_pc.php" method="POST">
        <!-- Asset Details Section -->
        <div class="form-group">
            <div class="form-field">
                <label for="assetID">Asset ID:</label>
                <input type="text" id="assetID" name="assetID" required>
            </div>
            <div class="form-field">
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" required>
            </div>
            <div class="form-field">
                <label for="cpu">CPU:</label>
                <input type="text" id="cpu" name="cpu" required>
            </div>
            <div class="form-field">
                <label for="ram">RAM:</label>
                <input type="text" id="ram" name="ram" required>
            </div>
        </div>

        <div class="form-group">
            <div class="form-field">
                <label for="storage">Storage:</label>
                <input type="text" id="storage" name="storage" required>
            </div>
            <div class="form-field">
                <label for="storage_size">Storage Size:</label>
                <input type="text" id="storage_size" name="storage_size" required>
            </div>
            <div class="form-field">
                <label for="os">OS:</label>
                <input type="text" id="os" name="os" required>
            </div>
            <div class="form-field">
                <label for="serial_no">Serial Number:</label>
                <input type="text" id="serial_no" name="serial_no" required>
            </div>
        </div>

        <div class="form-group">
            <div class="form-field">
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required>
            </div>
            <div class="form-field">
                <label for="purchDate">Purchase Date:</label>
                <input type="date" id="purchDate" name="purchDate" required>
            </div>
            <div class="form-field">
                <label for="warranty">Warranty Expiration:</label>
                <input type="date" id="warranty" name="warranty" required>
            </div>
            <div class="form-field">
                <label for="monitor_id">Monitor:</label>
                <select name="monitor_id" id="monitor_id" required>
                    <?php
                    // Fetch monitors from database
                    $result = mysqli_query($conn, "SELECT * FROM monitor");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['monitor_id'] . "'>" . $row['model'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="form-field">
                <label for="keyboard_mouse_id">Keyboard & Mouse:</label>
                <select name="keyboard_mouse_id" id="keyboard_mouse_id" required>
                    <?php
                    // Fetch keyboard and mouse data from database
                    $result = mysqli_query($conn, "SELECT * FROM keyboard_mouse");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['keyboard_mouse_id'] . "'>" . $row['model'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-field">
                <label for="user_id">User:</label>
                <select name="user_id" id="user_id" required>
                    <?php
                    // Fetch users from database
                    $result = mysqli_query($conn, "SELECT * FROM users");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['user_id'] . "'>" . $row['username'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- Buttons Section -->
        <div style="display: flex; gap: 10px;">
            <button type="submit">Add PC Asset</button>
            <button type="button" onclick="cancelAdding()">Cancel</button>
        </div>
    </form>
</main>

<!-- Success Popup -->
<div id="successPopup" class="popup">
    <div class="popup-content">
        <h4>Asset Added Successfully!</h4>
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
        window.location.href = 'cat.pc.php'; // Redirect to the desired page
    }

    function cancelAdding() {
        window.location.href = 'cat.pc.php'; // Redirect to the asset listing page
    }
</script>
</body>
</html>
