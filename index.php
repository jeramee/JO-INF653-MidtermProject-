<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getVehicleClasses($conn) {
    // Assume implementation here
}

// Sample data for demonstration
$vehicles = [
    ['class_name' => 'Compact', 'make' => 'Toyota', 'model' => 'Corolla', 'description' => 'Compact car'],
    ['class_name' => 'SUV', 'make' => 'Ford', 'model' => 'Escape', 'description' => 'Sport Utility Vehicle'],
    ['class_name' => 'Sedan', 'make' => 'Honda', 'model' => 'Civic', 'description' => 'Sedan car'],
    // More sample data...
];

// Include the admin header
include "./view/public_header.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zippy Used Autos - Public Page</title>
    <!-- Include the script tag for showErrorPopup -->
    <script>
        function showErrorPopup() {
            alert("Error inserting data: Duplicate vehicle in that category.");
            // You can use a more sophisticated modal/popup library if needed
        }
    </script>
</head>
<body>


    <!-- Navigation links -->
    <ul>
        <li><a href="#">View All Makes</a></li>
        <li><a href="#">View All Types</a></li>
        <li><a href="#">View All Classes</a></li>
    </ul>

    <!-- Category Filter Form -->
    <form action='index.php' method='post'>
        <label for="category_id">Filter by Class:</label>
        <select name="category_id" id="category_id">
            <?php
            $vehicleClasses = getVehicleClasses($GLOBALS['conn']);
            foreach ($vehicleClasses as $class) : ?>
                <option value="<?php echo $class['class_id']; ?>">
                    <?php echo $class['class_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Sorting options -->
    <form action="#" method="post">
        <label for="sorting">Sorted by:</label>
        <select name="sorting" id="sorting">
            <option value="price">Price</option>
            <option value="year">Year</option>
        </select>
        <input type="submit" value="Submit">
    </form>

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
                    echo "<td>{$vehicle['year']}</td>";
                    echo "<td>{$vehicle['make']}</td>";
                    echo "<td>{$vehicle['model']}</td>";
                    echo "<td>{$vehicle['type']}</td>";
                    echo "<td>{$vehicle['class']}</td>";
                    echo "<td>{$vehicle['price']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No vehicles in this class yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Include the script tag for showErrorPopup -->
    <script>
        // Call the showErrorPopup function if needed
        // showErrorPopup();
    </script>

    <!-- Include the footer -->
    <?php include "./view/footer.php"; ?>
</body>
</html>
