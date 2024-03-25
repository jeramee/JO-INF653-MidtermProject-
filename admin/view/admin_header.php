<!-- ../view/admin_header.php -->
<?php
include_once('../model/database.php');
include_once('../model/class_db.php');
include_once('../model/make_db.php');
include_once('../model/type_db.php');
include_once('../model/vehicle_db.php');


// Function to get all makes from the vehicle_make table
function getAllMakes($conn) {
    try {
        $query = "SELECT * FROM vehicle_make"; // Select all columns from the vehicle_make table
        $statement = $conn->prepare($query);
        $statement->execute();
        $makes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $makes;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching makes: " . $e->getMessage());
    }
}

// Function to get all types from the vehicle_type table
function getAllTypes($conn) {
    try {
        $query = "SELECT * FROM vehicle_type"; // Select all columns from the vehicle_type table
        $statement = $conn->prepare($query);
        $statement->execute();
        $types = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $types;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching types: " . $e->getMessage());
    }
}

// Function to get all classes from the vehicle_class table
function getAllClasses($conn) {
    try {
        $query = "SELECT * FROM vehicle_class"; // Select all columns from the vehicle_class table
        $statement = $conn->prepare($query);
        $statement->execute();
        $classes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $classes;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching classes: " . $e->getMessage());
    }
}

// Attempt to fetch data from the vehicle_inventory table
try {
    $vehicles = getAllData($GLOBALS['conn']);
} catch (PDOException $e) {
    // Display a verbose warning and error explanation
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching data from the database. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}

// Function to get all data from the vehicle_inventory table based on the selected class, type, and make
function getAllData($conn, $selectedClass = null, $selectedType = null, $selectedMake = null) {
    try {
        $query = "SELECT * FROM vehicle_inventory WHERE 1"; // Start with a basic query

        // Add conditions to the query based on the selected class, type, and make
        if ($selectedClass !== null && $selectedClass !== '#') {
            $query .= " AND class_id = :class_id";
        }
        if ($selectedType !== null && $selectedType !== '#') {
            $query .= " AND type_id = :type_id";
        }
        if ($selectedMake !== null && $selectedMake !== '#') {
            $query .= " AND make_id = :make_id";
        }

        // Prepare the query
        $statement = $conn->prepare($query);

        // Bind parameters if they exist
        if ($selectedClass !== null && $selectedClass !== '#') {
            $statement->bindParam(':class_id', $selectedClass);
        }
        if ($selectedType !== null && $selectedType !== '#') {
            $statement->bindParam(':type_id', $selectedType);
        }
        if ($selectedMake !== null && $selectedMake !== '#') {
            $statement->bindParam(':make_id', $selectedMake);
        }

        // Execute the query
        $statement->execute();

        // Fetch all data
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Close the cursor
        $statement->closeCursor();

        return $data;
    } catch (PDOException $e) {
        // Handle the exception appropriately, such as logging the error or displaying a user-friendly message
        throw new PDOException("Error fetching data from vehicle_inventory: " . $e->getMessage());
    }
}

// Variable to store all data
$vehicles = [];

// Attempt to fetch data from the vehicle_inventory table
try {
    $vehicles = getAllData($GLOBALS['conn']);
} catch (PDOException $e) {
    // Display a verbose warning and error explanation
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching data from the database. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}

// Filter vehicles based on the selected class
$selectedClass = isset($_GET['class']) ? $_GET['class'] : null;
$selectedType = isset($_GET['type']) ? $_GET['type'] : null;
$selectedMake = isset($_GET['make']) ? $_GET['make'] : null;
$filteredVehicles = $vehicles; // Start with all vehicles

// Call the getAllTypes function to fetch types from the database
$types = getAllTypes($conn);

// Call the getAllMakes function to fetch makes from the database
$makes = getAllMakes($conn);

// Call the getAllClasses function to fetch classes from the database
$classes = getAllClasses($conn);

// Apply filters sequentially
// Filter based on class
if ($selectedClass !== null && $selectedClass !== '#') {
    $filteredVehicles = array_filter($filteredVehicles, function($vehicle) use ($selectedClass) {
        return $vehicle['class_id'] === $selectedClass;
    });
}

// Filter based on type
if ($selectedType !== null && $selectedType !== '#') {
    $filteredVehicles = array_filter($filteredVehicles, function($vehicle) use ($selectedType) {
        return $vehicle['type_id'] === $selectedType;
    });
}

// Filter based on make
if ($selectedMake !== null && $selectedMake !== '#') {
    $filteredVehicles = array_filter($filteredVehicles, function($vehicle) use ($selectedMake) {
        return $vehicle['make_id'] === $selectedMake;
    });
}


// Sorting options
$sorting = isset($_POST['sorting']) ? $_POST['sorting'] : null;

// Function to compare vehicles based on price
function comparePrice($a, $b) {
    return $a['vehicle_price'] - $b['vehicle_price'];
}

// Function to compare vehicles based on year
function compareYear($a, $b) {
    return $a['vehicle_year'] - $b['vehicle_year'];
}

// Sort filtered vehicles based on selected sorting option
if ($sorting === 'price') {
    usort($filteredVehicles, 'comparePrice');
} elseif ($sorting === 'year') {
    usort($filteredVehicles, 'compareYear');
}

function getMakeNameById($makeId, $makes) {
    foreach ($makes as $make) {
        if ($make['make_id'] == $makeId) {
            return $make['make_name'];
        }
    }
    return 'Unknown Make'; // Return a default value if the make is not found
}

function getTypeNameById($typeId, $types) {
    foreach ($types as $type) {
        if ($type['type_id'] == $typeId) {
            return $type['type_name'];
        }
    }
    return 'Unknown Type'; // Return a default value if the type is not found
}

function getClassNameById($classId, $classes) {
    foreach ($classes as $class) {
        if ($class['class_id'] == $classId) {
            return $class['class_name'];
        }
    }
    return 'Unknown Class'; // Return a default value if the class is not found
}

// Handle form submission to remove vehicle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_vehicle'])) {
    $vehicle_id = $_POST['vehicle_id'];
    try {
        // Prepare and execute the DELETE query
        $query = "DELETE FROM vehicle_inventory WHERE vehicle_id = :vehicle_id";
        $statement = $conn->prepare($query);
        $statement->bindParam(':vehicle_id', $vehicle_id);
        $statement->execute();
        
        // Redirect back to the same page after removing the vehicle
        header("Location: admin_inventory.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors if the DELETE query fails
        echo "Error: An error occurred while removing the vehicle. Please try again.";
        echo "Error Message: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zippy Used Autos</title>
    <link rel="stylesheet" href="../view/css/main.css"> <!-- Include your CSS file -->
</head>
<body>
<header>
    <h1>Zippy Used Autos - Admin Page</h1>
</header>
