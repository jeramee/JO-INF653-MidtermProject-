<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to retrieve vehicle classes from the database
function getVehicleClasses($conn) {
    // Assume implementation here
}

try {
    // Include the admin header
    require_once "../view/admin_header.php";
} catch (Exception $e) {
    echo "Error loading admin header: " . $e->getMessage();
}

?>

<!-- Category Filter Form -->
<form action='index.php' method='post'>
    <label for="category_id">Filter by Class:</label>
    <select name="category_id" id="category_id">
        <?php
        try {
            $vehicleClasses = getVehicleClasses($GLOBALS['conn']);
            foreach ($vehicleClasses as $class) : ?>
                <option value="<?php echo $class['class_id']; ?>">
                    <?php echo $class['class_name']; ?>
                </option>
            <?php endforeach;
        } catch (Exception $e) {
            echo "Error fetching vehicle classes: " . $e->getMessage();
        }
        ?>
    </select>
    <button type="submit">Filter</button>
</form>

<?php
try {
    // Initialize $vehicles here
    $vehicles = []; // Example initialization, replace with actual data
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
} catch (Exception $e) {
    echo "Error fetching vehicle classes: " . $e->getMessage();
}
?>

<!-- Vehicle table -->
<table border="1">
    <thead>
        <tr>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>Type</th>
            <th>Class</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($vehicles) > 0) {
            foreach ($vehicles as $vehicle) {
                echo "<tr>";
                echo "<td>{$vehicle['year']}</td>"; // Display Year
                echo "<td>{$vehicle['make']}</td>"; // Display Make
                echo "<td>{$vehicle['model']}</td>"; // Display Model
                echo "<td>{$vehicle['type']}</td>"; // Display Type
                echo "<td>{$vehicle['class']}</td>"; // Display Class
                echo "<td>{$vehicle['price']}</td>"; // Display Price
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No vehicles in this class yet.</td></tr>";
        }
        ?>
    </tbody>
</table>
<!-- Include the footer -->
<?php require "../view/footer.php"; ?>

</body>
</html>
