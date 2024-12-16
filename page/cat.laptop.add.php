<?php
require_once '../classes/dbh.classes.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Dbh();
    $conn = $db->conn;

// Prepare and bind parameters
$sql = "INSERT INTO laptop (
    AssetTag, Manufacturer, Model, SerialNumber, PurchaseDate, WarrantyExpiryDate, ProcessorBrand, ProcessorModel,
    RAMType, RAMSize, RAMSpeed, NumberOfSlots, StorageType, StorageCapacity, Interface, NumberOfDrives,
    GPUType, GPUBrand, GPUModel, ScreenSize, Resolution, RefreshRate, WiFiType, EthernetPort, USBPorts,
    HDMIPort, BatteryCapacity, ChargerDetails, OSName, OSVersion, Weight, Color, Username
) VALUES (
    :AssetTag, :Manufacturer, :Model, :SerialNumber, :PurchaseDate, :WarrantyExpiryDate, :ProcessorBrand, :ProcessorModel,
    :RAMType, :RAMSize, :RAMSpeed, :NumberOfSlots, :StorageType, :StorageCapacity, :Interface, :NumberOfDrives,
    :GPUType, :GPUBrand, :GPUModel, :ScreenSize, :Resolution, :RefreshRate, :WiFiType, :EthernetPort, :USBPorts,
    :HDMIPort, :BatteryCapacity, :ChargerDetails, :OSName, :OSVersion, :Weight, :Color, :Username
)";

$stmt = $conn->prepare($sql);

try {
    $stmt->execute([
        ':AssetTag' => $_POST['AssetTag'],
        ':Manufacturer' => $_POST['Manufacturer'],
        ':Model' => $_POST['Model'],
        ':SerialNumber' => $_POST['SerialNumber'],
        ':PurchaseDate' => $_POST['PurchaseDate'],
        ':WarrantyExpiryDate' => $_POST['WarrantyExpiryDate'],
        ':ProcessorBrand' => $_POST['ProcessorBrand'],
        ':ProcessorModel' => $_POST['ProcessorModel'],
        ':RAMType' => $_POST['RAMType'],
        ':RAMSize' => $_POST['RAMSize'],
        ':RAMSpeed' => $_POST['RAMSpeed'],
        ':NumberOfSlots' => $_POST['NumberOfSlots'],
        ':StorageType' => $_POST['StorageType'],
        ':StorageCapacity' => $_POST['StorageCapacity'],
        ':Interface' => $_POST['Interface'],
        ':NumberOfDrives' => $_POST['NumberOfDrives'],
        ':GPUType' => $_POST['GPUType'],
        ':GPUBrand' => $_POST['GPUBrand'],
        ':GPUModel' => $_POST['GPUModel'],
        ':ScreenSize' => $_POST['ScreenSize'],
        ':Resolution' => $_POST['Resolution'],
        ':RefreshRate' => $_POST['RefreshRate'],
        ':WiFiType' => $_POST['WiFiType'],
        ':EthernetPort' => isset($_POST['EthernetPort']) ? 1 : 0,
        ':USBPorts' => $_POST['USBPorts'],
        ':HDMIPort' => isset($_POST['HDMIPort']) ? 1 : 0,
        ':BatteryCapacity' => $_POST['BatteryCapacity'],
        ':ChargerDetails' => $_POST['ChargerDetails'],
        ':OSName' => $_POST['OSName'],
        ':OSVersion' => $_POST['OSVersion'],
        ':Weight' => $_POST['Weight'],
        ':Color' => $_POST['Color'],
        ':Username' => $_POST['Username'],
    ]);

// Redirect with success flag
header("Location: cat.laptop.add.php?success=true");
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
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 10rem; color: #fff; max-width: 1200px; margin: 0 auto; box-sizing: border-box;">
        <a href="home.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Dashboard</a>
        <a href="asset.php" class="active" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem; background-color: #c0392b;">Assets</a>
        <a href="mainten.php" style="text-decoration: none; color: #fff; font-weight: bold; padding: 0.3rem 0.8rem; border-radius: 5px; transition: background-color 0.3s; font-size: 0.9rem;">Maintenance</a>
    </nav>
</header>

    <main>
        <h3>Add New Asset</h3>

        <form action="cat.laptop.add.php" method="POST">
            <!-- Asset Details Section -->
            <div class="form-group">
                <div class="form-field">
                    <label for="AssetTag">Asset Tag:</label>
                    <input type="text" id="AssetTag" name="AssetTag" required>
                </div>
                <div class="form-field">
                    <label for="Manufacturer">Manufacturer:</label>
                    <input type="text" id="Manufacturer" name="Manufacturer" required>
                </div>
                <div class="form-field">
                    <label for="Model">Model:</label>
                    <input type="text" id="Model" name="Model" required>
                </div>
                <div class="form-field">
                    <label for="SerialNumber">Serial Number:</label>
                    <input type="text" id="SerialNumber" name="SerialNumber" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="PurchaseDate">Purchase Date:</label>
                    <input type="date" id="PurchaseDate" name="PurchaseDate" required>
                </div>
                <div class="form-field">
                    <label for="WarrantyExpiryDate">Warranty Expiry Date:</label>
                    <input type="date" id="WarrantyExpiryDate" name="WarrantyExpiryDate" required>
                </div>
                <div class="form-field">
                    <label for="ProcessorBrand">Processor Brand:</label>
                    <input type="text" id="ProcessorBrand" name="ProcessorBrand" required>
                </div>
                <div class="form-field">
                    <label for="ProcessorModel">Processor Model:</label>
                    <input type="text" id="ProcessorModel" name="ProcessorModel" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="RAMType">RAM Type:</label>
                    <input type="text" id="RAMType" name="RAMType" required>
                </div>
                <div class="form-field">
                    <label for="RAMSize">RAM Size:</label>
                    <input type="number" id="RAMSize" name="RAMSize" required>
                </div>
                <div class="form-field">
                    <label for="RAMSpeed">RAM Speed:</label>
                    <input type="text" id="RAMSpeed" name="RAMSpeed" required>
                </div>
                <div class="form-field">
                    <label for="NumberOfSlots">Number of Slots:</label>
                    <input type="number" id="NumberOfSlots" name="NumberOfSlots" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="StorageType">Storage Type:</label>
                    <input type="text" id="StorageType" name="StorageType" required>
                </div>
                <div class="form-field">
                    <label for="StorageCapacity">Storage Capacity:</label>
                    <input type="number" id="StorageCapacity" name="StorageCapacity" required>
                </div>
                <div class="form-field">
                    <label for="Interface">Interface:</label>
                    <input type="text" id="Interface" name="Interface" required>
                </div>
                <div class="form-field">
                    <label for="NumberOfDrives">Number of Drives:</label>
                    <input type="number" id="NumberOfDrives" name="NumberOfDrives" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="GPUType">GPU Type:</label>
                    <input type="text" id="GPUType" name="GPUType" required>
                </div>
                <div class="form-field">
                    <label for="GPUBrand">GPU Brand:</label>
                    <input type="text" id="GPUBrand" name="GPUBrand" required>
                </div>
                <div class="form-field">
                    <label for="GPUModel">GPU Model:</label>
                    <input type="text" id="GPUModel" name="GPUModel" required>
                </div>
                <div class="form-field">
                    <label for="ScreenSize">Screen Size:</label>
                    <input type="number" id="ScreenSize" name="ScreenSize" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="Resolution">Resolution:</label>
                    <input type="text" id="Resolution" name="Resolution" required>
                </div>
                <div class="form-field">
                    <label for="RefreshRate">Refresh Rate:</label>
                    <input type="number" id="RefreshRate" name="RefreshRate" required>
                </div>
                <div class="form-field">
                    <label for="WiFiType">WiFi Type:</label>
                    <input type="text" id="WiFiType" name="WiFiType" required>
                </div>
                <div class="form-field">
                    <label for="EthernetPort">Ethernet Port:</label>
                    <input type="checkbox" id="EthernetPort" name="EthernetPort">
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="USBPorts">USB Ports:</label>
                    <input type="number" id="USBPorts" name="USBPorts" required>
                </div>
                <div class="form-field">
                    <label for="HDMIPort">HDMI Port:</label>
                    <input type="checkbox" id="HDMIPort" name="HDMIPort">
                </div>
                <div class="form-field">
                    <label for="BatteryCapacity">Battery Capacity:</label>
                    <input type="number" id="BatteryCapacity" name="BatteryCapacity" required>
                </div>
                <div class="form-field">
                    <label for="ChargerDetails">Charger Details:</label>
                    <input type="text" id="ChargerDetails" name="ChargerDetails" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="OSName">Operating System:</label>
                    <input type="text" id="OSName" name="OSName" required>
                </div>
                <div class="form-field">
                    <label for="OSVersion">OS Version:</label>
                    <input type="text" id="OSVersion" name="OSVersion" required>
                </div>
                <div class="form-field">
                    <label for="Weight">Weight:</label>
                    <input type="number" id="Weight" name="Weight" required>
                </div>
                <div class="form-field">
                    <label for="Color">Color:</label>
                    <input type="text" id="Color" name="Color" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label for="Username">Username:</label>
                    <input type="text" id="Username" name="Username" required>
                </div>
            </div>


                      <!-- Buttons Section -->
          <div style="display: flex; gap: 10px;">
            <button type="submit">Add Asset</button>
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
        window.location.href = 'cat.laptop.php'; // Redirect to the desired page
    }
</script>

<script>
    function cancelAdding() {
        window.location.href = 'cat.laptop.php'; // Redirect to the asset listing page
    }
</script>

</body>
</html>
