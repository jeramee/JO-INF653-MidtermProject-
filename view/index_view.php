<!-- index_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Inventory</title>
    <script>
        function showErrorPopup() {
            alert("Error inserting data: Duplicate vehicle in that category.");
            // You can use a more sophisticated modal/popup library if needed
        }
    </script>
</head>
<body>
    <h1>Vehicle Inventory</h1>

    <!-- Category Filter Form -->
    <form action='index.php' method='post'>
        <label for="category_id">Filter by Class:</label>
        <select name="category_id" id="category_id">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $vehicleClasses = getVehicleClasses($GLOBALS['conn']);
            foreach ($vehicleClasses as $class) : ?>
                <option value="<?php echo $class['class_id']; ?>">
                    <?php echo $class['class_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if (count($vehicles) > 0) {
        foreach ($vehicles as $vehicle) {
            echo "<div>";
            echo "<span>{$vehicle['class_name']}</span><br>"; // Display Class Name
            echo "<span>{$vehicle['make']} {$vehicle['model']}</span>";
            echo "<br><br> <!-- Add two line breaks for more space -->";
            echo "<span>{$vehicle['description']}</span><br><br>";
            echo "<form action='index.php' method='post'>";
            echo "<input type='hidden' name='removeVehicleId' value='{$vehicle['vehicle_id']}'>";
            echo "<button type='submit' style='color: red;'>X Remove</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No vehicles in this class yet.</p>";
    }
    ?>

    <!-- Add Vehicle Link -->
    <br><br>
    <a href="../controller/add_vehicle_view.php">Add Vehicle</a>
</body>
</html>
