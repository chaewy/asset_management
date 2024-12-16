<?php
session_start();

// Check if the session variable 'users_email' exists
if (isset($_SESSION['users_email'])) {
} else {
    echo "No email found in session. Please log in.";
}

if (isset($_SESSION['users_email'])) {
    $email = $_SESSION['users_email'];

    // Split the email at '@' and take the first part (the username)
    $username = explode('@', $email)[0];

} else {
    echo "No email found in session. Please log in.";
}

require_once '../classes/dbh.classes.php';

$db = new Dbh();
$conn = $db->conn;

// Fetch all maintenance records for Recent Activity (no search)
try {
    $sql = "SELECT * FROM maintenance_records ORDER BY date DESC"; // Order by date for recent activity
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $maintenanceRecordsRecent = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}

// Fetch filtered maintenance records for Manage Maintenance
$searchTerm = $_GET['search'] ?? ''; // Search term from the query string

try {
    $sql = "SELECT * FROM maintenance_records 
            WHERE asset_tag LIKE :search 
               OR category LIKE :search 
               OR status LIKE :search 
            ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':search' => '%' . $searchTerm . '%']);
    $maintenanceRecordsManage = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard • IT Asset Management</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/mainten.css">
    
</head>
<body>



<header>
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 2rem; color: #fff; max-width: 1200px; margin: 0 auto; box-sizing: border-box;">
        <!-- Empty div to maintain spacing -->
        <div></div>

        <!-- Center navigation links -->
        <div style="display: flex; gap: 20rem; justify-content: center;">
            <a href="home.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Dashboard</a>
            <a href="asset.php" class="active" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Assets</a>
            <a href="mainten.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem; margin-right: 8rem;  background-color: #c0392b;">Maintenance</a>
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



    
    <div class="main-content">

<!-- Recent Activity Section (Unchanged by Search) -->
<section class="recent-activity" style="margin-bottom: 2rem;">
    <h2>Recent Activity</h2>
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr>
                <th style="padding: 8px; text-align: center; " >Date</th>
                <th style="padding: 8px; text-align: center; " >Asset</th>
                <th style="padding: 8px; text-align: center; " >Category</th>
                <th style="padding: 8px; text-align: center; " >Status</th>
                <th style="padding: 8px; text-align: center; ">Technician</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($maintenanceRecordsRecent)) : ?>
                <?php foreach ($maintenanceRecordsRecent as $record) : ?>
                    <tr>
                        <td style="padding: 8px; text-align: center; " ><?= htmlspecialchars($record['date']) ?></td>
                        <td style="padding: 8px; text-align: center; " ><?= htmlspecialchars($record['asset_tag']) ?></td>
                        <td style="padding: 8px; text-align: center; " ><?= htmlspecialchars($record['category']) ?></td>
                        <td style="padding: 8px; text-align: center; " ><?= htmlspecialchars($record['status']) ?></td>
                        <td style="padding: 8px; text-align: center; " ><?= htmlspecialchars($record['performed_by'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No maintenance records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>


<!-- Manage Maintenance Section -->
<section class="manage-maintenance" style="margin-bottom: 1rem;">
    <h2>Manage Maintenance</h2>

    <!-- Flex container for the search bar and buttons -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: ;">

    <!-- Buttons -->
    <div style="display: flex; gap: 0.5rem;">
    <a href="mainten/add_mainten.php">
    <button type="button" style="margin-top: 1rem; background-color: rgb(0, 190, 48); color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer;">Add Maintenance</button>
    </a>

            <button type="submit" style="margin-top: 1rem; background-color: #f44336; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer;">Delete Selected</button>
        </div>

        <!-- Search Bar -->
        <section class="search-bar" style="flex-grow: 1;">
            <form method="GET" action="" style="display: flex; width: 100%; padding: 0.5rem;">
                <div style="display: flex; width: 100%; max-width: 500px;">
                    <input type="text" name="search" placeholder="Search by Asset, Type, or Status" value="<?= htmlspecialchars($searchTerm) ?>" style="flex-grow: 1; padding: 0.8rem; border: 1px solid #ccc; border-radius: 10px 0 0 10px; font-size: 1rem; outline: none; transition: border-color 0.3s ease;">
                    <button type="submit" style="background-color: rgb(131, 131, 131); color: white; border: none; padding: 0.8rem 1.2rem; font-size: 1rem; border-radius: 0 10px 10px 0; cursor: pointer; transition: background-color 0.3s ease;">Search</button>
                </div>
            </form>
        </section>

        
    </div>



    <!-- Maintenance Records Table (Filtered by Search) -->
<section class="recent-activity" style="margin-bottom: 2rem;">
    <form method="POST" action="mainten/delete_selected.php">
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
    <tr>
        <th style="width: 5%; text-align: center;"> <!-- Center the checkbox column -->
            <input type="checkbox" id="select-all" onclick="toggleSelectAll()"> <!-- No text, just the checkbox -->
        </th>
        <th style="padding: 8px; text-align: center;">Date</th> <!-- Center the text -->
        <th style="padding: 8px; text-align: center;">AssetTag</th> <!-- Center the text -->
        <th style="padding: 8px; text-align: center;">Category</th> <!-- Center the text -->
        <th style="padding: 8px; text-align: center;">Status</th> <!-- Center the text -->
        <th style="padding: 8px; text-align: center;">Technician</th> <!-- Center the text -->
        <th style="padding: 8px; text-align: center;">Actions</th> <!-- Center the text -->
    </tr>
</thead>


<tbody>
    <?php if (!empty($maintenanceRecordsManage)) : ?>
        <?php foreach ($maintenanceRecordsManage as $record) : ?>
            <tr>
                <td style="text-align: center;"><input type="checkbox" name="selected_records[]" value="<?= $record['id'] ?>"></td> <!-- Checkbox aligned center -->
                <td style="padding: 8px; text-align: center; "><?= htmlspecialchars($record['date']) ?></td>
                <td style="padding: 8px; text-align: center; "><?= htmlspecialchars($record['asset_tag']) ?></td>
                <td style="padding: 8px; text-align: center; "><?= htmlspecialchars($record['category']) ?></td>
                <td style="padding: 8px; text-align: center; "><?= htmlspecialchars($record['status']) ?></td>
                <td style="padding: 8px; text-align: center; "><?= htmlspecialchars($record['performed_by'] ?? '') ?></td>
                <td style="padding: 8px; text-align: center; ">
                    <a href="mainten/edit_mainten.php?id=<?= $record['id'] ?>">Edit</a>
                    <a href="mainten/delete_mainten.php?id=<?= $record['id'] ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7">No maintenance records found.</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
        
    </form>
</section>


        



    </section>





   





        </div>
    </div>

    <footer>
        <p>&copy; 2024 IT Asset Management. All rights reserved.</p>
    </footer>



</body>
</html>


<script>
    // Function to toggle the "Select All" checkbox
    function toggleSelectAll() {
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="selected_records[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }
</script>
