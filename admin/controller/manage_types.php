<!-- ../controller/manage_types.php -->
<?php
include_once('../model/database.php');
include_once('../model/class_db.php');
include_once('../model/make_db.php');
include_once('../model/type_db.php');
include_once('../model/vehicle_db.php');


// Function to get all types from the database
function getAllTypes($conn) {
    try {
        $query = "SELECT * FROM vehicle_type"; // Select all columns from the vehicle_type table        
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

// Function to get all makes from the database
function getAllMakes($conn) {
    try {
        $query = "SELECT * FROM vehicle_make"; // Select all columns from the vehicle_make table
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
    // Display a verbose warning and error explanation
    echo "<strong>Warning:</strong> An error occurred while fetching makes from the database. Please check the database connection and make sure the 'vehicle_make' table exists.<br>";
    echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
}

// Function to get all classes from the database
function getAllClasses($conn) {
    try {
        $query = "SELECT * FROM vehicle_class"; // Select all columns from the vehicle_class table
        $statement = $conn->prepare($query);
        $statement->execute();
        $classes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $classes;
    } catch (PDOException $e) {
        // Handle the exception appropriately, such as logging the error or displaying a user-friendly message
        throw new PDOException("Error fetching classes: " . $e->getMessage());
    }
}

// Variable to store classes
$classes = [];

// Attempt to fetch classes from the database
try {
    $classes = getAllClasses($GLOBALS['conn']); // Attempt to fetch classes
} catch (PDOException $e) {
    // Display a verbose warning and error explanation
    echo "<strong>Warning:</strong> An error occurred while fetching classes from the database. Please check the database connection and make sure the 'vehicle_class' table exists.<br>";
    echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
}

// Function to get all data from the vehicle_inventory table
function getAllData($conn) {
    try {
        $query = "SELECT * FROM vehicle_inventory"; // Select all columns from the vehicle_inventory table
        $statement = $conn->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $data;
    } catch (PDOException $e) {
        // Handle the exception appropriately, such as logging the error or displaying a user-friendly message
        throw new PDOException("Error fetching data from vehicle_inventory: " . $e->getMessage());
    }
}

// Variable to store data
$vehicles = [];

// Attempt to fetch data from the vehicle_inventory table
try {
    $vehicles = getAllData($GLOBALS['conn']);
} catch (PDOException $e) {
    // Display a verbose warning and error explanation
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching data from the database. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}

// Call the getAllTypes function to fetch types from the database
$types = getAllTypes($conn);

// Call the getAllMakes function to fetch makes from the database
$makes = getAllMakes($conn);

// Call the getAllClasses function to fetch classes from the database
$classes = getAllClasses($conn);

// Call the getAllClasses function to fetch classes from the database
$vehicle = getAllData($conn);

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
    <p><a href="../controller/admin_inventory.php">View Full Vehicle List</a></p>
    <p><a href="../view/add_vehicle_view.php">Click here to add a vehicle</a></p>
    <p><a href="../view/add_make_view.php">View/Edit Vehicle Makes</a></p>
    <p><a href="../view/add_type_view.php">View/Edit Vehicle Types</a></p>
    <p><a href="../view/add_class_view.php">View/Edit Vehicle Classes</a></p>
</body>
</html>
