<!-- ../controller/manage_makes.php -->
<?php
include_once('../model/database.php');
include_once('../model/make_db.php');

// Function to get all makes from the database
function getAllMakes($conn) {
    try {
        $query = "SELECT * FROM makes";
        $statement = $conn->prepare($query);
        $statement->execute();
        $makes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $makes;
    } catch (PDOException $e) {
        // Handle the exception appropriately, such as logging the error or displaying a user-friendly message
        throw new PDOException("Error fetching makes: " . $e->getMessage());
    }
}

// Variable to store makes
$makes = [];

// Attempt to fetch makes from the database
try {
    $makes = getAllMakes($GLOBALS['conn']); // Attempt to fetch makes
} catch (PDOException $e) {
    // Display a verbose warning and error explanation for line 44
    echo "<strong>Warning:</strong> An error occurred while fetching makes from the database. Please check the database connection and make sure the 'makes' table exists.<br>";
    echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Vehicle Make List</title>
</head>
<body>
    <h1>Admin Vehicle Make List</h1>
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

    <!-- Vehicle Make List -->
    <h3>Vehicle Make List</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($makes as $make) : ?>
                <tr>
                    <td><?php echo $make['make_name']; ?></td>
                    <td><a href="remove_make.php?id=<?php echo $make['make_id']; ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add Vehicle Make Form -->
    <h3>Add Vehicle Make</h3>
    <form action="add_make.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <button type="submit">Add Make</button>
    </form>

    <!-- Additional links -->
    <p><a href="view_full_vehicle_list.php">View Full Vehicle List</a></p>
    <p><a href="add_vehicle.php">Click here to add a vehicle</a></p>
    <p><a href="manage_types.php">View/Edit Vehicle Types</a></p>
    <p><a href="manage_classes.php">View/Edit Vehicle Classes</a></p>
</body>
</html>

