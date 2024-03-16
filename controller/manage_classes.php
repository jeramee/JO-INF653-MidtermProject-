<!-- ../controller/manage_classes.php -->
<?php
include_once('../model/database.php');
include_once('../model/class_db.php');

// Function to get all data from the specified table
function getAllData($conn, $tableName) {
    try {
        $query = "SELECT * FROM $tableName"; // Use the provided table name
        $statement = $conn->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $data;
    } catch (PDOException $e) {
        // Handle the exception appropriately, such as logging the error or displaying a user-friendly message
        throw new PDOException("Error fetching data from $tableName: " . $e->getMessage());
    }
}

// Variable to store data
$classes = [];
$makes = [];
$prices = [];
$types = [];
$years = [];

// Attempt to fetch data from each table
try {
    $classes = getAllData($GLOBALS['conn'], 'vehicle_classes');
    $makes = getAllData($GLOBALS['conn'], 'vehicle_makes');
    $prices = getAllData($GLOBALS['conn'], 'vehicle_price');
    $types = getAllData($GLOBALS['conn'], 'vehicle_types');
    $years = getAllData($GLOBALS['conn'], 'vehicle_year');
} catch (PDOException $e) {
    // Display a verbose warning and error explanation
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching data from the database. Please check the database connection and make sure the tables exist. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
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
        <h1>Admin Page with Selection Classes</h1>
        <h2>Zippy Admin</h2>

        <!-- Navigation links -->
        <ul>
            <li><a href="#">View All Makes</a></li>
            <li><a href="#">Sedan</a></li>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class) : ?>
                    <tr>
                        <td><?php echo $years[$class['year_id']]['year'] ?? 'Undefined'; ?></td>
                        <td><?php echo $makes[$class['make_id']]['make_name'] ?? 'Undefined'; ?></td>
                        <td><?php echo $models[$class['model_id']]['model_name'] ?? 'Undefined'; ?></td>
                        <td><?php echo $types[$class['type_id']]['type_name'] ?? 'Undefined'; ?></td>
                        <td><?php echo $class['class_name']; ?></td>
                        <td><?php echo $prices[$class['price_id']]['price'] ?? '$0.00'; ?></td>
                        <td>Remove</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Additional links -->
        <p><a href="#">View Full Vehicle List</a></p>
        <p><a href="#">Click here to add a vehicle</a></p>
        <p><a href="#">View/Edit Vehicle Makes</a></p>
        <p><a href="#">View/Edit Vehicle Types</a></p>
        <p><a href="#">View/Edit Vehicle Classes</a></p>
    </div>
</



