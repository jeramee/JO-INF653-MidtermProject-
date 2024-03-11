<?php
include('../model/database.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Check if 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $vehicleId = $_GET['id'];

        // Remove the vehicle from the database based on vehicle_id
        $stmt = $conn->prepare("DELETE FROM vehicles WHERE vehicle_id = :id");
        $stmt->bindParam(':id', $vehicleId);
        $stmt->execute();

        // Redirect back to the admin page after removing the vehicle
        header("Location: admin/index.php");
        exit();
    } else {
        // Redirect to the admin page if 'id' parameter is not set
        header("Location: admin/index.php");
        exit();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
