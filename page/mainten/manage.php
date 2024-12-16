<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Management</title>
    <link rel="stylesheet" href="../css/mainten.css">
</head>
<body>
    <header>
        <nav class="tab-bar">
            <a href="home.php">Dashboard</a>
            <a href="asset.php">Assets</a>
            <a href="mainten.php" class="active">Maintenance</a>
        </nav>
    </header>

    <main>
        <h2>Maintenance Records</h2>
        <div class="table-controls">
            <input type="date" id="maintenanceDateFilter">
            <select id="assetFilter">
                <option value="">All Assets</option>
                <option value="Laptop">Laptop</option>
                <option value="PC">PC</option>
            </select>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Asset ID</th>
                    <th>Maintenance Date</th>
                    <th>Details</th>
                    <th>Cost</th>
                    <th>Next Maintenance Due</th>
                </tr>
            </thead>
            <tbody>
                <!-- Populate from the backend -->
            </tbody>
        </table>
        <button>Add Maintenance Record</button>
    </main>

    <footer>
        <p>&copy; 2024 IT Asset Management. All rights reserved.</p>
    </footer>
</body>
</html>
