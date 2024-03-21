<!-- ../controller/public_inventory.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('../model/database.php');
include_once('../model/vehicle_db.php');



try {
    // Fetch vehicles from the database
    $vehicles = getPublicInventory($GLOBALS['conn']); // Assuming getPublicInventory function retrieves vehicles from the database
    
    // Check if classes were fetched successfully
    if (!empty($classes)) {
        echo "Success: Classes fetched from the database.<br>";
        // Output fetched classes for debugging
        echo "Fetched classes: <pre>";
        print_r($classes);
        echo "</pre>";
    } else {
        echo "Info: No classes found in the database.<br>";
    }
} catch (PDOException $e) {
    // Display an error message if fetching classes fails
    echo "Error: Failed to fetch classes from the database. Error message: " . $e->getMessage() . "<br>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zippy Used Autos - Public Page</title>
</head>
<body>
    <h1>Zippy Used Autos - Public Page</h1>

    <!-- Navigation links -->
    <ul>
        <li><a href="#">View All Makes</a></li>
        <li><a href="#">View All Types</a></li>
        <li><a href="#">View All Classes</a></li>
    </ul>

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
            <?php foreach ($vehicles as $vehicle) : ?>
                <tr>
                    <td><?php echo $vehicle['year']; ?></td>
                    <td><?php echo $vehicle['make']; ?></td>
                    <td><?php echo $vehicle['model']; ?></td>
                    <td><?php echo $vehicle['type']; ?></td>
                    <td><?php echo $vehicle['class']; ?></td>
                    <td><?php echo '$' . number_format($vehicle['price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
