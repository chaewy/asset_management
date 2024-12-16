<?php
session_start(); // Ensure this is at the top


// Check if the session variable 'users_email' exists
if (isset($_SESSION['users_email'])) {
    // echo "Welcome! Your email is: " . htmlspecialchars($_SESSION['users_email']);s
} else {
    echo "No email found in session. Please log in.";
}

if (isset($_SESSION['users_email'])) {
    $email = $_SESSION['users_email'];

    // Split the email at '@' and take the first part (the username)
    $username = explode('@', $email)[0];

    // echo htmlspecialchars($username); // Display only the username part
} else {
    echo "No email found in session. Please log in.";
}







?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard • IT Asset Management</title>
    <link rel="stylesheet" href="../css/home.css">
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/mainten.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<header>
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 2rem; color: #fff; max-width: 1200px; margin: 0 auto; box-sizing: border-box;">
        <!-- Empty div to maintain spacing -->
        <div></div>

        <!-- Center navigation links -->
        <div style="display: flex; gap: 20rem; justify-content: center;">
            <a href="home.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem; background-color: #c0392b;">Dashboard</a>
            <a href="asset.php" class="active" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Assets</a>
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



    <div class="main-content">
        <h2>Overview</h2>

        <!-- Statistics boxes -->
        <div class="stats">
            <div class="stat-box">
                <h3>Total Assets</h3>
                <p>150</p>
            </div>
            <div class="stat-box">
                <h3>In Use</h3>
                <p>980</p>
            </div>
            <div class="stat-box">
                <h3>Available</h3>
                <p>270</p>
            </div>
        </div>

        <h2>Asset Overview Graphs</h2>

        <div class="graphs">
            
            <div class="graph-container">
                <canvas id="assetChart1" height="300" width="400" ></canvas>
            </div>
            <div class="graph-container">
                <canvas id="summaryChart" height="300" width="400" ></canvas>
            </div>
            <div class="graph-container">
                <canvas id="usageChart" height="300" width="400" ></canvas>
            </div>
            <div class="graph-container">
                <canvas id="inventoryChart" height="300" width="400" ></canvas>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <ul>
                <li>John Doe assigned Laptop #2031</li>
                <li>Jane Smith returned Monitor #312</li>
                <li>New printer added to inventory</li>
            </ul>
        </div>
        
    </div>

    <footer>
        <p>&copy; 2024 IT Asset Management. All rights reserved.</p>
    </footer>

    <script>
        // Sample data for the charts

        // Toggle the slide-in panel


        const ctx1 = document.getElementById('assetChart1').getContext('2d');
        const assetChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Asset A', 'Asset B', 'Asset C'],
                datasets: [{
                    label: 'Total Assets',
                    data: [120, 190, 300],
                    backgroundColor: 'rgba(52, 152, 219, 0.5)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('summaryChart').getContext('2d');
        const summaryChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Assets Summary',
                    data: [50, 100, 75, 120, 90, 150],
                    fill: false,
                    borderColor: 'rgba(231, 76, 60, 1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx3 = document.getElementById('usageChart').getContext('2d');
        const usageChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['In Use', 'Available'],
                datasets: [{
                    label: 'Usage Distribution',
                    data: [980, 270],
                    backgroundColor: ['rgba(39, 174, 96, 0.5)', 'rgba(52, 152, 219, 0.5)'],
                    borderColor: ['rgba(39, 174, 96, 1)', 'rgba(52, 152, 219, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
            }
        });

        const ctx4 = document.getElementById('inventoryChart').getContext('2d');
        const inventoryChart = new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: ['Functional', 'Non-Functional'],
                datasets: [{
                    label: 'Inventory Status',
                    data: [200, 50],
                    backgroundColor: ['rgba(241, 196, 15, 0.5)', 'rgba(192, 57, 43, 0.5)'],
                    borderColor: ['rgba(241, 196, 15, 1)', 'rgba(192, 57, 43, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
            }
        });

       





    </script>
</body>
</html>
