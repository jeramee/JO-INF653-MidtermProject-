<!-- ../controller/manage_classes.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Display a greeting message
echo "Hello, world!<br>";

// Include necessary files
include_once('../model/database.php');
include_once('../model/class_db.php');

// Check if the database connection is established
if ($GLOBALS['conn']) {
    echo "Success: Database connection established.<br>";
} else {
    echo "Error: Failed to connect to the database.<br>";
}

// Check if the form is submitted to add a new class
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addClass'])) {
    // Check if the class name is provided
    if (isset($_POST['className']) && !empty($_POST['className'])) {
        $className = $_POST['className'];

        // Attempt to add the class to the database
        try {
            addVehicleClass($GLOBALS['conn'], $className);
            echo "Success: Class '{$className}' has been added to the database.<br>";
        } catch (PDOException $e) {
            echo "Error: Failed to add class '{$className}' to the database. Error message: " . $e->getMessage() . "<br>";
        }
    } else {
        // Display a message indicating that class name is required
        echo "Error: Class name is required.<br>";
    }
}

// Check if the form is submitted to remove a class
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeClass'])) {
    // Check if the class ID is provided
    if (isset($_POST['classId']) && !empty($_POST['classId'])) {
        $classId = $_POST['classId'];

        // Attempt to remove the class from the database
        try {
            removeVehicleClass($GLOBALS['conn'], $classId);
            echo "Success: Class with ID '{$classId}' has been removed from the database.<br>";
        } catch (PDOException $e) {
            echo "Error: Failed to remove class with ID '{$classId}' from the database. Error message: " . $e->getMessage() . "<br>";
        }
    } else {
        // Display a message indicating that class ID is required
        echo "Error: Class ID is required.<br>";
    }
}

try {
    // Fetch all existing classes from the database
    $classes = getVehicleClasses($GLOBALS['conn']);
    
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

// Your HTML code to display the form to add/remove classes and to list existing classes...
?>

<!-- HTML form to add a class -->
<form method="post" action="manage_classes.php">
    <label for="className">Class Name:</label>
    <input type="text" id="className" name="className" required>
    <button type="submit" name="addClass">Add Class</button>
</form>

