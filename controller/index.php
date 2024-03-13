<!-- index.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include_once('../model/database.php');
include_once('../model/class_db.php');
include_once('../model/make_db.php');
include_once('../model/type_db.php');
include_once('../model/vehicle_db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submissions
    if (isset($_POST['removeVehicleId'])) {
        $vehicleId = $_POST['removeVehicleId'];

        // Attempt to remove the vehicle
        if (removeVehicle($GLOBALS['conn'], $vehicleId)) {
            echo "Vehicle successfully removed.";
        } else {
            echo "Error removing vehicle.";
        }

        // Redirect to index.php to display the updated list
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['make']) && isset($_POST['type']) && isset($_POST['class']) && isset($_POST['year']) && isset($_POST['price']) && isset($_POST['description'])) {
        // Extract form data
        $make = $_POST['make'];
        $type = $_POST['type'];
        $class = $_POST['class'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        // Validate and sanitize input
        // You may need to perform additional validation here

        // Insert vehicle into the database
        if (addVehicle($GLOBALS['conn'], $make, $type, $class, $year, $price, $description)) {
            echo "Vehicle successfully added.";
        } else {
            echo "Error adding vehicle.";
        }

        // Redirect back to index.php after adding a new vehicle
        header("Location: index.php");
        exit();
    }
}

// Get vehicles from the database
$vehicles = getVehicles($GLOBALS['conn']);

// Display the form and vehicle list
include('../view/index_view.php');

?>

<!-- index_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../view/css/main.css"> <!-- Include main.css -->
    <title>Add Vehicle</title>
</head>
<body>
    <h1>Add Vehicle</h1>

    <!-- Form elements -->
    <form action="../controller/index.php" method="post">
        <label for="make">Make:</label>
        <input type="text" id="make" name="make" required>
        <br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required>
        <br>

        <label for="class">Class:</label>
        <input type="text" id="class" name="class" required>
        <br>

        <label for="year">Year:</label>
        <input type="text" id="year" name="year" required>
        <br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>

        <button type="submit">Add Vehicle</button>
    </form>

    <!-- Vehicle list -->
    <h2>Vehicle List</h2>
    <ul>
        <?php foreach ($vehicles as $vehicle) : ?>
            <li>
                <?php echo $vehicle['make'] . ' ' . $vehicle['type'] . ' ' . $vehicle['year']; ?>
                <form action="../controller/index.php" method="post" style="display: inline;">
                    <input type="hidden" name="removeVehicleId" value="<?php echo $vehicle['id']; ?>">
                    <button type="submit">Remove</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
