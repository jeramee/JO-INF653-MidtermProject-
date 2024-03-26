<!-- ../view/add_vehicle_view.php -->
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection and necessary functions
include_once('../model/database.php');
include_once('../model/class_db.php');
include_once('../model/make_db.php');
include_once('../model/type_db.php');
include_once('../model/vehicle_db.php');

// Function to get all classes from the vehicle_class table
function getAllClasses($conn) {
    try {
        $query = "SELECT DISTINCT class_id, class_name FROM vehicle_class";
        $statement = $conn->prepare($query);
        $statement->execute();
        $classes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $classes;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching classes: " . $e->getMessage());
    }
}

// Function to get all makes from the vehicle_inventory table
function getAllMakes($conn) {
    try {
        $query = "SELECT DISTINCT make_id, make_name FROM vehicle_make";        
        $statement = $conn->prepare($query);
        $statement->execute();
        $makes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $makes;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching makes: " . $e->getMessage());
    }
}

// Function to get all types from the vehicle_inventory table
function getAllTypes($conn) {
    try {
        $query = "SELECT DISTINCT type_id, type_name FROM vehicle_type";        
        $statement = $conn->prepare($query);
        $statement->execute();
        $types = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $types;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching types: " . $e->getMessage());
    }
}

// Fetch all classes, makes, and types and sort them alphabetically
$classes = [];
$makes = [];
$types = [];

try {
    $classes = getAllClasses($GLOBALS['conn']);
    $makes = getAllMakes($GLOBALS['conn']);
    $types = getAllTypes($GLOBALS['conn']);
    
    // Sort classes, makes, and types alphabetically
    usort($classes, function($a, $b) {
        return strcmp($a['class_id'], $b['class_id']);
    });
    usort($makes, function($a, $b) {
        return strcmp($a['make_id'], $b['make_id']);
    });
    usort($types, function($a, $b) {
        return strcmp($a['type_id'], $b['type_id']);
    });
} catch (PDOException $e) {
    // Display error message if fetching fails
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching data. Please check the database connection and make sure the tables exist. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}

// Function to add a new vehicle
function addVehicle($conn, $year, $make, $model, $type, $class, $price) {
    try {
        // Prepare and execute the INSERT query
        $query = "INSERT INTO vehicle_inventory (vehicle_year, make_id, vehicle_model, type_id, class_id, vehicle_price) VALUES (:year, :make, :model, :type, :class, :price)";
        $statement = $conn->prepare($query);
        $statement->bindParam(':year', $year);
        $statement->bindParam(':make', $make);
        $statement->bindParam(':model', $model);
        $statement->bindParam(':type', $type);
        $statement->bindParam(':class', $class);
        $statement->bindParam(':price', $price);
        $statement->execute();

        // Output verbose information
        echo "<div style='color: green;'><strong>Success:</strong> Vehicle added successfully. Details:<br>";
        echo "Year: $year<br>";
        echo "Make: $make<br>";
        echo "Model: $model<br>";
        echo "Type: $type<br>";
        echo "Class: $class<br>";
        echo "Price: $price<br>";
        echo "</div><br>";
    } catch (PDOException $e) {
        // Handle any errors if the INSERT query fails
        throw new PDOException("Error adding vehicle: " . $e->getMessage());
    }
}

// Handle form submission to add vehicle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_vehicle'])) {
    // Retrieve form data
    $year = $_POST['year'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $type = $_POST['type'];
    $class = $_POST['class'];
    $price = $_POST['price'];

    try {
        // Prepare and execute the SQL insert statement
        $query = "INSERT INTO vehicle_inventory (vehicle_year, make_id, vehicle_model, type_id, class_id, vehicle_price) 
                  VALUES (:year, :make, :model, :type, :class, :price)";
        $statement = $conn->prepare($query);
        $statement->bindParam(':year', $year);
        $statement->bindParam(':make', $make);
        $statement->bindParam(':model', $model);
        $statement->bindParam(':type', $type);
        $statement->bindParam(':class', $class);
        $statement->bindParam(':price', $price);
        $statement->execute();

        // Output success message
        echo "<div style='color: green;'><strong>Success:</strong> Vehicle added successfully. Details:<br>";
        echo "Year: $year<br>";
        echo "Make: $make<br>";
        echo "Model: $model<br>";
        echo "Type: $type<br>";
        echo "Class: $class<br>";
        echo "Price: $price<br>";
        echo "</div><br>";

        // Redirect back to the same page after adding the vehicle
        header("Location: admin_inventory.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors
        echo "<div style='color: red;'><strong>Error:</strong> An error occurred while adding the vehicle. Please try again. <br>";
        echo "Error Message: " . $e->getMessage() . "</div><br>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Add Vehicle Page</title>
    <!-- Include any additional head elements from original code here... -->
</head>
<body>
    <h1>Zippy Admin</h1>

    <!-- Form elements -->
    <form action="../view/add_vehicle_view.php" method="post">
        <label for="make">Make:</label>
        <select id="make" name="make" required>
            <?php foreach ($makes as $make) : ?>
                <?php if(isset($make['make_name'])): ?>
                    <option value="<?php echo $make['make_id']; ?>"><?php echo $make['make_name']; ?></option>
                <?php else: ?>
                    <!-- Debugging -->
                    <option value="">No Make Name Found</option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <br>


        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <?php foreach ($types as $type) : ?>
                <option value="<?php echo $type['type_id']; ?>"><?php echo $type['type_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="class">Class:</label>
        <select id="class" name="class" required>
            <?php foreach ($classes as $class) : ?>
                <option value="<?php echo $class['class_id']; ?>"><?php echo $class['class_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <!-- Add text box for Year -->
        <label for="year">Year:</label>
        <input type="text" id="year" name="year" required>
        <br>

        <!-- Add text box for Model -->
        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>
        <br>

        <!-- Add text box for Price -->
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
        <br>

        <!-- Add submit button -->
        <button type="submit">Add Vehicle</button>
    </form>

    <!-- Additional links -->
    <p><a href="../controller/admin_inventory.php">View Full Vehicle List</a></p>
    <p><a href="../view/add_vehicle_view.php">Click here to add a vehicle</a></p>
    <p><a href="#">View/Edit Vehicle Makes</a></p>
    <p><a href="#">View/Edit Vehicle Types</a></p>
    <p><a href="#">View/Edit Vehicle Classes</a></p>   

    <!-- Display form values for troubleshooting -->
    <div>
        <h2>Form Values for Troubleshooting:</h2>
        <p>Make: <?php echo isset($_POST['make']) ? $_POST['make'] : ''; ?></p>
        <p>Type: <?php echo isset($_POST['type']) ? $_POST['type'] : ''; ?></p>
        <p>Class: <?php echo isset($_POST['class']) ? $_POST['class'] : ''; ?></p>
        <p>Year: <?php echo isset($_POST['year']) ? $_POST['year'] : ''; ?></p>
        <p>Model: <?php echo isset($_POST['model']) ? $_POST['model'] : ''; ?></p>
        <p>Price: <?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?></p>
    </div>
</body>
</html>
