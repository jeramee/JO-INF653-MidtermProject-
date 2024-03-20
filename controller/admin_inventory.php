<!-- ../controller/admin_inventory.php -->
<?php
include_once('../model/database.php');
include_once('../model/class_db.php');

// Function to get all classes from the vehicle_class table
function getAllClasses($conn) {
    try {
        $query = "SELECT DISTINCT vehicle_class FROM vehicle_inventory";
        $statement = $conn->prepare($query);
        $statement->execute();
        $classes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $classes;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching classes: " . $e->getMessage());
    }
}

// Variable to store data
$classes = [];

// Attempt to fetch data from the vehicle_class table
try {
    $classes = getAllClasses($GLOBALS['conn']);
} catch (PDOException $e) {
    // Display a verbose warning and error explanation
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching classes. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}

// Function to get all makes from the vehicle_inventory table
function getAllMakes($conn) {
    try {
        $query = "SELECT DISTINCT vehicle_make FROM vehicle_inventory"; // Select distinct makes from the vehicle_inventory table
        $statement = $conn->prepare($query);
        $statement->execute();
        $makes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $makes;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching makes: " . $e->getMessage());
    }
}

// Variable to store data
$makes = [];

// Attempt to fetch data from the vehicle_inventory table
try {
    $makes = getAllMakes($GLOBALS['conn']);
} catch (PDOException $e) {
    // Display a verbose warning and error explanation
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching makes. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}

// Function to get all types from the vehicle_type table
function getAllTypes($conn) {
    try {
        $query = "SELECT DISTINCT vehicle_type FROM vehicle_inventory";
        $statement = $conn->prepare($query);
        $statement->execute();
        $types = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $types;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching types: " . $e->getMessage());
    }
}

// Variable to store data
$types = [];

// Attempt to fetch data from the vehicle_type table
try {
    $types = getAllTypes($GLOBALS['conn']);
} catch (PDOException $e) {
    // Display a verbose warning and error explanation
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching types. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
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

// Apply filters sequentially
// Filter based on class
if ($selectedClass !== null && $selectedClass !== '#') {
    $filteredVehicles = array_filter($filteredVehicles, function($vehicle) use ($selectedClass) {
        return $vehicle['vehicle_class'] === $selectedClass;
    });
}

// Filter based on type
if ($selectedType !== null && $selectedType !== '#') {
    $filteredVehicles = array_filter($filteredVehicles, function($vehicle) use ($selectedType) {
        return $vehicle['vehicle_type'] === $selectedType;
    });
}

// Filter based on make
if ($selectedMake !== null && $selectedMake !== '#') {
    $filteredVehicles = array_filter($filteredVehicles, function($vehicle) use ($selectedMake) {
        return $vehicle['vehicle_make'] === $selectedMake;
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
        echo "<div style='color: red;'><strong>Error:</strong> An error occurred while removing the vehicle. Please try again. <br>";
        echo "Error Message: " . $e->getMessage() . "</div><br>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page with Selection Classes</title>
    <style>
        /* Add some basic styling for better presentation */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Zippy Admin</h1>

        <!-- Navigation links -->
        <ul>
            <li>
                <!-- Display the dropdown menu for types -->
                <select id="typeSelect">
                    <option value="#" <?php if ($selectedType === null) echo 'selected'; ?>>View All Types</option> <!-- Default value -->
                    <?php foreach ($types as $type) : ?>
                        <option value="<?php echo $type['vehicle_type']; ?>" <?php if ($selectedType === $type['vehicle_type']) echo 'selected'; ?>><?php echo $type['vehicle_type']; ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <li>
                <!-- Display the dropdown menu for makes -->
                <select id="makeSelect">
                    <option value="#" <?php if ($selectedMake === null) echo 'selected'; ?>>View All Makes</option> <!-- Default value -->
                    <?php foreach ($makes as $make) : ?>
                        <option value="<?php echo $make['vehicle_make']; ?>" <?php if ($selectedMake === $make['vehicle_make']) echo 'selected'; ?>><?php echo $make['vehicle_make']; ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <li>
                <!-- Display the dropdown menu for classes -->
                <form id="classForm">
                    <select id="classSelect">
                        <option value="#" <?php if ($selectedClass === null) echo 'selected'; ?>>View All Classes</option>
                        <?php foreach ($classes as $class) : ?>
                            <option value="<?php echo $class['vehicle_class']; ?>" <?php if ($selectedClass === $class['vehicle_class']) echo 'selected'; ?>><?php echo $class['vehicle_class']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </li>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Filtered vehicles will be loaded dynamically based on the selected class -->
                <?php foreach ($filteredVehicles as $vehicle) : ?>
                    <tr>
                        <td><?php echo $vehicle['vehicle_year']; ?></td>
                        <td><?php echo $vehicle['vehicle_make']; ?></td>
                        <td><?php echo $vehicle['vehicle_model']; ?></td>
                        <td><?php echo $vehicle['vehicle_type']; ?></td>
                        <td><?php echo $vehicle['vehicle_class']; ?></td>
                        <td>$<?php echo $vehicle['vehicle_price']; ?></td>
                        <td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['vehicle_id']; ?>">
                                <button type="submit" name="remove_vehicle">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Additional links -->
        <p><a href="#">View Full Vehicle List</a></p>
        <p><a href="../view/add_vehicle_view.php">Click here to add a vehicle</a></p>
        <p><a href="../view/add_make_view.php">View/Edit Vehicle Makes</a></p>
        <p><a href="../view/add_type_view.php">View/Edit Vehicle Types</a></p>
        <p><a href="../view/add_class_view.php">View/Edit Vehicle Classes</a></p>
    </div>

    <script>
        // JavaScript to redirect to manage_classes_view.php with the selected class, type, and make
        document.getElementById('classSelect').addEventListener('change', function() {
            var selectedClass = this.value;
            var selectedType = document.getElementById('typeSelect').value;
            var selectedMake = document.getElementById('makeSelect').value;
            // Redirect to the correct location: view/manage_classes_view.php with the selected parameters
            window.location.href = '../view/manage_classes_view.php?class=' + encodeURIComponent(selectedClass) + '&type=' + encodeURIComponent(selectedType) + '&make=' + encodeURIComponent(selectedMake);
        });

        // JavaScript to redirect to manage_types_view.php with the selected type, class, and make
        document.getElementById('typeSelect').addEventListener('change', function() {
            var selectedType = this.value;
            var selectedClass = document.getElementById('classSelect').value;
            var selectedMake = document.getElementById('makeSelect').value;
            // Redirect to the correct location: view/manage_types_view.php with the selected parameters
            window.location.href = '../view/manage_types_view.php?type=' + encodeURIComponent(selectedType) + '&class=' + encodeURIComponent(selectedClass) + '&make=' + encodeURIComponent(selectedMake);
        });

        // JavaScript to redirect to manage_makes_view.php with the selected make, class, and type
        document.getElementById('makeSelect').addEventListener('change', function() {
            var selectedMake = this.value;
            var selectedClass = document.getElementById('classSelect').value;
            var selectedType = document.getElementById('typeSelect').value;
            // Redirect to the correct location: view/manage_makes_view.php with the selected parameters
            window.location.href = '../view/manage_makes_view.php?make=' + encodeURIComponent(selectedMake) + '&class=' + encodeURIComponent(selectedClass) + '&type=' + encodeURIComponent(selectedType);
        });
    </script>


</body>
</html>
