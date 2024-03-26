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

    if (isset($_POST['make'], $_POST['type'], $_POST['class'], $_POST['year'], $_POST['price'], $_POST['description'])) {
        // Extract form data
        $make = $_POST['make'];
        $type = $_POST['type'];
        $class = $_POST['class'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        // Validate and sanitize input
        // I may need to perform additional validation here

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

// Determine if the user is an admin or not (assuming I have a way to determine this)
$isAdmin = false; // Set this to true if the user is logged in as an admin

// Include the appropriate view file based on the user's role
if ($isAdmin) {
    include('../view/admin_inventory_view.php'); // Include the admin view file
} else {
    include('../view/public_inventory_view.php'); // Include the public view file
}
?>
