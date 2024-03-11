<!-- add_vehicle.php -->
<?php
// Ensure error reporting is enabled for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include_once('../model/database.php');
include_once('../model/vehicle_db.php');
include_once('../model/make_db.php'); // Add appropriate include for make database operations
include_once('../model/type_db.php'); // Add appropriate include for type database operations
include_once('../model/class_db.php'); // Add appropriate include for class database operations

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['make']) && isset($_POST['model'])) {
    // Extract form data
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $class = $_POST['class'];
    
    // Validate and sanitize input
    try {
        // Check if make, type, and class already exist, if not, add them to the database
        $makeId = getMakeId($GLOBALS['conn'], $make);
        if (!$makeId) {
            addMake($GLOBALS['conn'], $make);
            $makeId = getMakeId($GLOBALS['conn'], $make);
        }

        $typeId = getTypeId($GLOBALS['conn'], $type);
        if (!$typeId) {
            addType($GLOBALS['conn'], $type);
            $typeId = getTypeId($GLOBALS['conn'], $type);
        }

        $classId = getClassId($GLOBALS['conn'], $class);
        if (!$classId) {
            addClass($GLOBALS['conn'], $class);
            $classId = getClassId($GLOBALS['conn'], $class);
        }

        // Insert into the database
        addVehicle($GLOBALS['conn'], $makeId, $model, $year, $price, $typeId, $classId);

        // Redirect back to add_vehicle.php after adding a new vehicle
        header("Location: ../view/add_vehicle.php");
        exit();
    } catch (PDOException $e) {
        echo "Error inserting data: " . $e->getMessage();
        exit();
    }
}

// Fetch makes, types, and classes for dropdown menus
$makes = getMakes($GLOBALS['conn']);
$types = getTypes($GLOBALS['conn']);
$classes = getClasses($GLOBALS['conn']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
</head>
<body>
    <h1>Add Vehicle</h1>

    <!-- Form elements -->
    <form action="/path-to-your-controller/add_vehicle.php" method="post">
        <label for="make">Make:</label>
        <select name="make" id="make">
            <?php foreach ($makes as $make) : ?>
                <option value="<?php echo $make['make_name']; ?>">
                    <?php echo $make['make_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>
        <br>

        <label for="year">Year:</label>
        <input type="text" id="year" name="year" required>
        <br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
        <br>

        <label for="type">Type:</label>
        <select name="type" id="type">
            <?php foreach ($types as $type) : ?>
                <option value="<?php echo $type['type_name']; ?>">
                    <?php echo $type['type_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="class">Class:</label>
        <select name="class" id="class">
            <?php foreach ($classes as $class) : ?>
                <option value="<?php echo $class['class_name']; ?>">
                    <?php echo $class['class_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <button type="submit">Add Vehicle</button>
    </form>

    <!-- Additional content -->
    <p>Enter the details for the new vehicle and click "Add Vehicle" to add it to the inventory.</p>
    <br><br>
    <p>You can also <a href="/path-to-your-controller/view_inventory.php">go back to the Inventory</a>.</p>
</body>
</html>
