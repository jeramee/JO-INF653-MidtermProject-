<!-- ../view/delete_vehicle_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Vehicle</title>
    <!-- Include any additional head elements from your original code here... -->
</head>
<body>
    <h1>Delete Vehicle</h1>

    <!-- Form elements -->
    <form action="../controller/delete.php" method="post">
        <label for="vehicle_id">Select Vehicle:</label>
        <select name="vehicle_id" id="vehicle_id" required>
            <?php foreach ($vehicles as $vehicle) : ?>
                <option value="<?php echo $vehicle['vehicle_id']; ?>">
                    <?php echo $vehicle['title']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <button type="submit">Delete Vehicle</button>
    </form>

    <!-- Additional content -->
    <p>Select a vehicle from the list and click "Delete Vehicle" to remove it from the inventory.</p>
    <br><br>
    <p>You can also <a href="../controller/index.php">go back to the Vehicle Inventory</a>.</p>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle form submission
        handleFormSubmission();
    }

    // Additional functions for managing vehicles can be added here...

    ?>

</body>
</html>

<?php
// Function to handle form submission
function handleFormSubmission() {
    echo "Handling form submission...\n"; // Output to the web page

    if (isset($_POST['vehicle_id'])) {
        // Extract form data
        $vehicle_id = $_POST['vehicle_id'];

        // Validate and sanitize input
        try {
            echo "Deleting Vehicle...\n"; // Output to the web page

            // Delete from the database (replace with your actual function)
            // deleteVehicle($GLOBALS['conn'], $vehicle_id);

            echo "Vehicle deleted successfully!\n"; // Output to the web page

            // Redirect back to delete_vehicle_view.php after deleting a vehicle
            header("Location: ../view/delete_vehicle_view.php");
            exit();
        } catch (PDOException $e) {
            echo "Error deleting data: " . $e->getMessage(); // Output to the web page
            exit();
        }
    } else {
        echo "Form data is incomplete.\n"; // Output to the web page
    }
}
?>
