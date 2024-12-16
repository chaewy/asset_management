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
    $sql = "SELECT * FROM laptop ";
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
    <style>
        /* Styling for the comparison modal */
        /* Styling for the comparison modal */
.comparison-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.comparison-modal .modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 1200px;
    overflow-x: auto; /* Allow horizontal scrolling */
    display: flex;
    flex-direction: column;
    align-items: center;
}

.comparison-modal .modal-content table {
    width: 100%;
    border-collapse: collapse;
    overflow-x: auto;
    white-space: nowrap;
}

.comparison-modal .modal-content table th, td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

.comparison-modal .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: red;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}
footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px;
}
/* Responsive button styles */
button {
    display: inline-block;
    margin: 1rem; /* Adjusts space between buttons */
    padding: 0.75rem 1.5rem; /* Controls button height and width proportionally */
    font-size: 1rem; /* Scales font size relative to base size */
    border: none;
    border-radius: 0.5rem; /* Rounded corners */
    background-color: #007bff; /* Primary button color */
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover {
    background-color: #0056b3; /* Darker shade on hover */
    transform: scale(1.05); /* Slightly enlarges button on hover */
}

button:active {
    background-color: #004085; /* Even darker shade when active */
    transform: scale(0.95); /* Slightly shrinks button when clicked */
}

#profile-popup {
    display: none;
    position: absolute;
    top: 40px;
    right: 0;
    background-color: #fff;
    color: #333;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

#profile-popup div {
    padding: 1rem;
}
#profile-popup p {
    margin: 0;
}
#profile-popup hr {
    margin: 0.5rem 0;
    border: 0;
    border-top: 1px solid #ccc;
}

/* Responsive design adjustments */
@media (max-width: 768px) {
    button {
        margin: 0.5rem; /* Reduce space between buttons on smaller screens */
        padding: 0.5rem 1rem; /* Adjust padding for smaller screens */
        font-size: 0.9rem; /* Slightly smaller font size */
    }
}

@media (max-width: 480px) {
    button {
        margin: 0.25rem; /* Further reduce spacing */
        padding: 0.4rem 0.8rem; /* Compact padding */
        font-size: 0.8rem; /* Smaller font size for very small screens */
        width: 100%; /* Make buttons full-width on very small screens */
    }
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
        <h3>Laptop Items</h3>

        <!-- Check for the status parameter in the URL -->
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <script>
                alert("Selected assets deleted successfully.");
            </script>
        <?php endif; ?>




       

        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2px;">

            <!-- Back to Categories Button -->
            <a href="asset.php" 
                style="text-decoration: none; padding: 7px 12px; background-color: #555555; border: none; border-radius: 4px; color: #fff; 
                font-weight: bold; transition: background-color 0.3s ease; margin-right: px;"
                onmouseover="this.style.backgroundColor='#333333';" 
                onmouseout="this.style.backgroundColor='#555555';"
            >&larr; Categories</a>

            <!-- Add New Asset Button -->
            <button onclick="window.location.href='cat.laptop.add.php';" 
                style="padding: 8px 12px; background-color: #007BFF; border: none; border-radius: 4px; color: #fff; 
                font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; margin-right: px;"
                onmouseover="this.style.backgroundColor='#0056b3';" 
                onmouseout="this.style.backgroundColor='#007BFF';"
            >Add Asset</button>

            <form id="deleteForm" method="POST" action="delete_laptop.php">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2px;">
                    <button type="button" onclick="submitDeleteForm()" style="padding: 8px 12px; background-color: #DC3545; border: none; border-radius: 4px; color: #fff; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease;">
                        Delete Selected
                    </button>
                </div>
            </form>

            <!-- Comparison Section Button -->
            <!-- <button onclick="showComparisonModal()" 
                style="padding: 8px 12px; background-color: #007BFF; border: none; border-radius: 4px; color: #fff; 
                font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; margin-right: 10px;"
                onmouseover="this.style.backgroundColor='#0056b3';" 
                onmouseout="this.style.backgroundColor='#007BFF';"
            >Compare Assets</button> -->

            <!-- Search and Filter Section -->
            <input type="text" id="searchInput" placeholder="Search by..." 
                onkeydown="checkEnterKey(event)" 
                style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; width: 200px; margin-right: 10px; margin-left: 780px">



        </div>

        <div class="table-container" style="overflow-x: auto; width: 100%; margin-top: 30px;">
            <table id="assetTable" style="min-width: 1200px; border-collapse: collapse;">

    
                <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll()"></th>
                    <th>Asset Tag</th>
                    <th>Manufacturer</th>
                    <th>Model</th>
                    <th>Serial Number</th>
                    <th>Purchase Date</th>
                    <th>Warranty Expiry Date</th>
                    <th>Processor Brand</th>
                    <th>Processor Model</th>
                    <th>RAM Type</th>
                    <th>RAM Size (GB)</th>
                    <th>RAM Speed (MHz)</th>
                    <th>Number of Slots</th>
                    <th>Storage Type</th>
                    <th>Storage Capacity</th>
                    <th>Interface</th>
                    <th>Number of Drives</th>
                    <th>GPU Type</th>
                    <th>GPU Brand</th>
                    <th>GPU Model</th>
                    <th>Screen Size (inches)</th>
                    <th>Resolution</th>
                    <th>Refresh Rate (Hz)</th>
                    <th>WiFi Type</th>
                    <th>Ethernet Port</th>
                    <th>USB Ports</th>
                    <th>HDMI Port</th>
                    <th>Battery Capacity</th>
                    <th>Charger Details</th>
                    <th>OS Name</th>
                    <th>OS Version</th>
                    <th>Weight (kg)</th>
                    <th>Color</th>
                    <th>Username</th>
                </tr>

                </thead>
                <tbody>
                    <?php foreach ($laptops as $laptop): ?>
                        <tr>
                            <td><input type="checkbox" class="asset-checkbox" value="<?php echo $laptop['AssetTag']; ?>"></td>
                            <td><?php echo $laptop['AssetTag']; ?></td>
                            <td><?php echo $laptop['Manufacturer']; ?></td>
                            <td><?php echo $laptop['Model']; ?></td>
                            <td><?php echo $laptop['SerialNumber']; ?></td>
                            <td><?php echo $laptop['PurchaseDate']; ?></td>
                            <td><?php echo $laptop['WarrantyExpiryDate']; ?></td>
                            <td><?php echo $laptop['ProcessorBrand']; ?></td>
                            <td><?php echo $laptop['ProcessorModel']; ?></td>
                            <td><?php echo $laptop['RAMType']; ?></td>
                            <td><?php echo $laptop['RAMSize']; ?> GB</td>
                            <td><?php echo $laptop['RAMSpeed']; ?> MHz</td>
                            <td><?php echo $laptop['NumberOfSlots']; ?></td>
                            <td><?php echo $laptop['StorageType']; ?></td>
                            <td><?php echo $laptop['StorageCapacity']; ?></td>
                            <td><?php echo $laptop['Interface']; ?></td>
                            <td><?php echo $laptop['NumberOfDrives']; ?></td>
                            <td><?php echo $laptop['GPUType']; ?></td>
                            <td><?php echo $laptop['GPUBrand']; ?></td>
                            <td><?php echo $laptop['GPUModel']; ?></td>
                            <td><?php echo $laptop['ScreenSize']; ?> inches</td>
                            <td><?php echo $laptop['Resolution']; ?></td>
                            <td><?php echo $laptop['RefreshRate']; ?> Hz</td>
                            <td><?php echo $laptop['WiFiType']; ?></td>
                            <td><?php echo $laptop['EthernetPort'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $laptop['USBPorts']; ?></td>
                            <td><?php echo $laptop['HDMIPort'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $laptop['BatteryCapacity']; ?></td>
                            <td><?php echo $laptop['ChargerDetails']; ?></td>
                            <td><?php echo $laptop['OSName']; ?></td>
                            <td><?php echo $laptop['OSVersion']; ?></td>
                            <td><?php echo $laptop['Weight']; ?> kg</td>
                            <td><?php echo $laptop['Color']; ?></td>
                            <td><?php echo $laptop['Username']; ?></td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>



        

        
  
    </main>
    <!-- Footer -->
    <footer>
        <p>&copy; 2024 IT Asset Management. All rights reserved.</p>
    </footer>

   

</div>

</div>



</body>


<script>


    function toggleSelectAll() {
        const selectAllCheckbox = document.getElementById("selectAll");
        const checkboxes = document.querySelectorAll(".asset-checkbox");
        checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
    }

    function submitDeleteForm() {
    const checkboxes = document.querySelectorAll(".asset-checkbox:checked");
    if (checkboxes.length === 0) {
        alert("Please select at least one asset to delete.");
        return;
    }

    // Get the IDs of the selected assets
    const ids = Array.from(checkboxes).map(checkbox => checkbox.value);

    // Show confirmation popup
    const confirmation = confirm("Are you sure you want to delete the selected assets?");
    if (confirmation) {
        const form = document.getElementById("deleteForm");

        // Clear any existing hidden inputs
        form.innerHTML = '';

        // Add hidden inputs with the IDs to the form
        ids.forEach(id => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "AssetTag[]";  // Ensure it's an array on the server side
            input.value = id;
            form.appendChild(input);
        });

        // Submit the form to delete the assets
        form.submit();
    }
}



    

    function showComparisonModal() {
        const selectedAssets = Array.from(document.querySelectorAll('.asset-checkbox:checked')).map(checkbox => checkbox.value);
        
        if (selectedAssets.length < 2) {
            alert('Please select at least two assets to compare.');
            return;
        }

        // Fetch asset data for the selected assets
        fetchComparisonData(selectedAssets);
    }

    function fetchComparisonData(assetTags) {
    const url = 'cat.laptop.comp.php'; // PHP script to fetch data
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ assetTags }), // Send the selected asset tags as JSON
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch comparison data.');
        }
        return response.json();
    })
    .then(data => {
        populateComparisonModal(data);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while fetching comparison data.');
    });
}

function populateComparisonModal(data) {
    const comparisonTableDiv = document.getElementById('comparisonTable');
    let tableHTML = '<table><thead><tr>';

    // Generate table headers dynamically
    for (const key in data[0]) {
        tableHTML += `<th>${key}</th>`;
    }
    tableHTML += '</tr></thead><tbody>';

    // Generate table rows for each asset
    data.forEach(asset => {
        tableHTML += '<tr>';
        for (const value of Object.values(asset)) {
            tableHTML += `<td>${value}</td>`;
        }
        tableHTML += '</tr>';
    });

    tableHTML += '</tbody></table>';
    comparisonTableDiv.innerHTML = tableHTML;

    // Show the modal
    const modal = document.getElementById('comparisonModal');
    modal.style.display = 'flex';
}

function closeComparisonModal() {
    const modal = document.getElementById('comparisonModal');
    modal.style.display = 'none';
}
    
    function checkEnterKey(event) {
    if (event.key === 'Enter') {
        filterTable();
    }
}

function filterTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#assetTable tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const matches = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchInput));
        row.style.display = matches ? '' : 'none';
    });
}




</script>







</html>
