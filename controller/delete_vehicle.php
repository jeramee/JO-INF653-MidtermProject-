<?php
include('../model/database.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Your existing delete_vehicle.php code for deleting vehicles...
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
