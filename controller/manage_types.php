<!-- ../controller/manage_types.php -->
<?php
include_once('../model/database.php');
include_once('../model/type_db.php');

// Function to get all types from the database
function getAllTypes($conn) {
    try {
        $query = "SELECT * FROM types";
        $statement = $conn->prepare($query);
        $statement->execute();
        $types = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $types;
    } catch (PDOException $e) {
        // Handle the exception appropriately, such as logging the error or displaying a user-friendly message
        throw new PDOException("Error fetching types: " . $e->getMessage());
    }
}

// Variable to store types
$types = [];

// Attempt to fetch types from the database
try {
    $types = getAllTypes($GLOBALS['conn']); // Attempt to fetch types
} catch (PDOException $e) {
    // Display a verbose warning and error explanation for line 44
    echo "<strong>Warning:</strong> An error occurred while fetching types from the database. Please check the database connection and make sure the 'types' table exists.<br>";
    echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Vehicle Type List</title>
</head>
<body>
    <h1>Admin Vehicle Type List</h1>
    <h2>Zippy Admin</h2>

    <!-- Sorting options -->
    <form action="#" method="post">
        <label for="sorting">Sorted by:</label>
        <select name="sorting" id="sorting">
            <option value="price">Price</option>
            <option value="year">Year</option>
        </select>
        <input type="submit" value="Submit">
    </form>

    <!-- Vehicle Type List -->
    <h3>Vehicle Type List</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($types as $type) : ?>
                <tr>
                    <td><?php echo $type['type_name']; ?></td>
                    <td><a href="remove_type.php?id=<?php echo $type['type_id']; ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add Vehicle Type Form -->
    <h3>Add Vehicle Type</h3>
    <form action="add_type.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <button type="submit">Add Type</button>
    </form>

    <!-- Additional links -->
    <p><a href="view_full_vehicle_list.php">View Full Vehicle List</a></p>
    <p><a href="add_vehicle.php">Click here to add a vehicle</a></p>
    <p><a href="manage_makes.php">View/Edit Vehicle Makes</a></p>
    <p><a href="manage_classes.php">View/Edit Vehicle Classes</a></p>
</body>
</html>
