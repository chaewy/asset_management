<?php


session_start(); // Ensure this is at the top

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


// Check if the status query parameter is set
// Check if the status query parameter is set
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo "<script>
        alert('Deletion successful');
        // Clear the URL after showing the alert
        history.replaceState(null, null, window.location.pathname);
    </script>";
}

    require_once '../classes/dbh.classes.php';

    $db = new Dbh();
    $conn = $db->conn;

    // Fetch all information on laptop table
    $sql = "SELECT * FROM pc ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt === false) {
        die('Query failed: ' . $conn->errorInfo()[2]);
    }

    // Fetch all rows
    $laptops = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$laptops) {
        die('No laptops found');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assets • IT Asset Management</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/cat.css"> 
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
        <h3>PC  Items</h3>


        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2px;">

            <!-- Back to Categories Button -->
            <a href="asset.php" 
                style="text-decoration: none; padding: 7px 12px; background-color: #555555; border: none; border-radius: 4px; color: #fff; 
                font-weight: bold; transition: background-color 0.3s ease; margin-right: px;"
                onmouseover="this.style.backgroundColor='#333333';" 
                onmouseout="this.style.backgroundColor='#555555';"
            >&larr; Back to Categories</a>

            <!-- Add New Asset Button -->
            <button onclick="window.location.href='cat.pc.add.php';" 
                style="padding: 8px 12px; background-color: #007BFF; border: none; border-radius: 4px; color: #fff; 
                font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; margin-right: px;"
                onmouseover="this.style.backgroundColor='#0056b3';" 
                onmouseout="this.style.backgroundColor='#007BFF';"
            >+ Add New Asset</button>

            <!-- Delete Asset Button -->
            <button onclick="showAddAssetModal()" 
                style="padding: 8px 12px; background-color: #007BFF; border: none; border-radius: 4px; color: #fff; 
                font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; margin-right: px;"
                onmouseover="this.style.backgroundColor='#0056b3';" 
                onmouseout="this.style.backgroundColor='#007BFF';"
            >+ Delete Asset</button>



            <!-- Asset Comparison Section -->
            <button onclick="showComparisonModal()" 
                style="padding: 8px 12px; background-color: #007BFF; border: none; border-radius: 4px; color: #fff; 
                font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; margin-right: 10px;"
                onmouseover="this.style.backgroundColor='#0056b3';" 
                onmouseout="this.style.backgroundColor='#007BFF';"
            >Compare Selected Assets</button>

            <!-- Search and Filter Section -->
            <input type="text" id="searchInput" placeholder="Search by Name or ID..." 
                onkeyup="filterTable()" 
                style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; width: 200px; margin-right: 10px; margin-left: 180px">

            <select id="filterDropdown" onchange="filterTable()" 
                style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-right: 10px;">
                <option value="">Filter by Category</option>
                <option value="Laptop">Laptop</option>
                <option value="PC">PC</option>
                <option value="Monitor">Monitor</option>
            </select>

        </div>


 





        <div class="table-container">
            <table id="assetTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll()"></th> <!-- Checkbox to select all -->
                        <th>AssetTag</th>
                        <th>Model</th>
                        <th>CPU</th>
                        <th>RAM</th>
                        <th>Storage</th>
                        <th>OS</th>
                        <th>Serial No.</th>
                        <th>Status</th>
                        <th>Purchase Date</th>
                        <th>Warranty</th>
                        <th>Monitor</th>
                        <th>Keyboard</th>
                        <th>Owner</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laptops as $laptop): ?>
                        <tr>
                            <td><input type="checkbox" class="asset-checkbox" value="<?php echo $laptop['AssetID']; ?>"></td>
                            <td><?php echo $laptop['AssetID']; ?></td>
                            <td><?php echo $laptop['Model']; ?></td>
                            <td><?php echo $laptop['CPU']; ?></td>
                            <td><?php echo $laptop['RAM']; ?></td>
                            <td><?php echo $laptop['Storage']; ?></td>
                            <td><?php echo $laptop['OS']; ?></td>
                            <td><?php echo $laptop['SerialNo']; ?></td>
                            <td><?php echo $laptop['Status']; ?></td>
                            <td><?php echo $laptop['PurchaseDate']; ?></td>
                            <td><?php echo $laptop['WarrantyExpiryDate']; ?></td>
                            <td><?php echo $laptop['MonitorID']; ?></td>
                            <td><?php echo $laptop['KeyboardMouseID']; ?></td>
                            <td><?php echo $laptop['UserID']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="../js/cat.js"></script>

    <script>
        // Select all checkboxes function
        function toggleSelectAll() {
            const isChecked = document.getElementById('selectAll').checked;
            const checkboxes = document.querySelectorAll('.asset-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = isChecked);
        }

        // Filter the table based on search input or dropdown
        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const filterDropdown = document.getElementById('filterDropdown').value;
            const rows = document.querySelectorAll('#assetTable tbody tr');

            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const category = row.cells[3].textContent.toLowerCase();
                const id = row.cells[0].textContent.toLowerCase();

                if ((name.includes(searchInput) || id.includes(searchInput)) && (filterDropdown === "" || category.includes(filterDropdown.toLowerCase()))) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

    <!-- Comparison Modal -->
    <div id="comparisonModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeComparisonModal()">&times;</span>
            <h3>Compare Assets</h3>
            <table id="comparisonTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specifications</th>
                        <th>Category</th>
                        <th>Purchase Date</th>
                        <th>Warranty Expiration</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic comparison rows will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Show comparison modal
        function showComparisonModal() {
            const selectedAssets = [];
            const checkboxes = document.querySelectorAll('.asset-checkbox:checked');
            
            checkboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                selectedAssets.push({
                    id: row.cells[1].textContent,
                    name: row.cells[2].textContent,
                    specs: row.cells[3].textContent,
                    category: row.cells[4].textContent,
                    purchaseDate: row.cells[5].textContent,
                    warrantyDate: row.cells[6].textContent
                });
            });

            if (selectedAssets.length > 1) {
                const tableBody = document.querySelector('#comparisonTable tbody');
                tableBody.innerHTML = '';  // Clear existing rows
                selectedAssets.forEach(asset => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${asset.id}</td>
                        <td>${asset.name}</td>
                        <td>${asset.specs}</td>
                        <td>${asset.category}</td>
                        <td>${asset.purchaseDate}</td>
                        <td>${asset.warrantyDate}</td>
                    `;
                    tableBody.appendChild(row);
                });
                document.getElementById('comparisonModal').style.display = 'block';
            } else {
                alert("Please select at least two assets to compare.");
            }
        }

        // Close comparison modal
        function closeComparisonModal() {
            document.getElementById('comparisonModal').style.display = 'none';
        }
    </script>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 IT Asset Management. All rights reserved.</p>
    </footer>

</body>
</html>
