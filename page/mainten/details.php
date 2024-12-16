<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Details</title>
    <link rel="stylesheet" href="details.css">
    <link rel="stylesheet" href="../../css/home.css">
</head>
<body>
<header>
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 10rem; color: #fff; max-width: 1200px; margin: 0 auto; box-sizing: border-box;">
        <a href="home.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Dashboard</a>
        <a href="asset.php"  style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Assets</a>
        <a href="mainten.php" class="active"style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem; background-color: #c0392b;">Maintenance</a>
    </nav>
</header>

    <main>

         <div class="navigation-buttons">
            <a href="../mainten.php" class="back-button">Go Back to Front Page</a>
        </div>


        <section class="asset-overview">
            <h2>Asset Overview</h2>
            <p><strong>Asset ID:</strong> A123</p>
            <p><strong>Name:</strong> Laptop - Dell XPS 15</p>
            <p><strong>Status:</strong> Active</p>
        </section>

        <section class="maintenance-history">
            <h2>Maintenance History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Details</th>
                        <th>Cost</th>
                        <th>Next Maintenance Due</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-01-15</td>
                        <td>Replaced battery</td>
                        <td>$150</td>
                        <td>2025-01-15</td>
                    </tr>
                    <tr>
                        <td>2024-06-10</td>
                        <td>System upgrade</td>
                        <td>$200</td>
                        <td>2025-06-10</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="add-maintenance-record">
            <h2>Add Maintenance Record</h2>
            <form action="add_maintenance.php" method="POST">
                <label for="maintenance-date">Date:</label>
                <input type="date" id="maintenance-date" name="maintenance-date" required>

                <label for="details">Details:</label>
                <textarea id="details" name="details" rows="3" required></textarea>

                <label for="cost">Cost:</label>
                <input type="number" id="cost" name="cost" required>

                <label for="next-due">Next Maintenance Due:</label>
                <input type="date" id="next-due" name="next-due" required>

                <button type="submit">Add Record</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 IT Asset Management. All rights reserved.</p>
    </footer>
</body>
</html>
