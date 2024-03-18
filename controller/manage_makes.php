<!-- ../controller/manage_makes.php -->
<?php
include_once('../model/database.php');
include_once('../model/class_db.php');

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page with Selection Makes</title>
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
        <h1>Admin Page with Selection Makes</h1>
        <h2>Zippy Admin</h2>

        <!-- Navigation links -->
        <ul>
            <li>
                <!-- Include the ../view/manage_makes_view.php file -->
                <?php include_once('../view/manage_makes_view.php'); ?>
            </li>
            <li>
                <!-- Include the ../view/manage_types_view.php file -->
                <?php include_once('../view/manage_types_view.php'); ?>
            </li>
            <li>
                <!-- Include the ../view/manage_classes_view.php file -->
                <?php include_once('../view/manage_classes_view.php'); ?>
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
                <?php foreach ($vehicles as $vehicle) : ?>
                    <tr>
                        <td><?php echo $vehicle['vehicle_year']; ?></td>
                        <td><?php echo $vehicle['vehicle_make']; ?></td>
                        <td><?php echo $vehicle['vehicle_model']; ?></td>
                        <td><?php echo $vehicle['vehicle_type']; ?></td>
                        <td><?php echo $vehicle['vehicle_class']; ?></td>
                        <td>$<?php echo $vehicle['vehicle_price']; ?></td>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var makeSelect = document.getElementById('makeSelect');
            if (makeSelect) {
                makeSelect.addEventListener('change', function() {
                    var selectedMake = this.value;

                    // Create element to display the selected make
                    var echoElement = document.createElement('p');
                    echoElement.textContent = 'Selected Make: ' + selectedMake;
                    document.body.appendChild(echoElement);

                    // Send AJAX request to fetch filtered vehicles based on the selected make
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                document.getElementById('vehicleList').innerHTML = xhr.responseText;
                            } else {
                                console.error('Failed to fetch filtered vehicles. Status:', xhr.status);
                            }
                        }
                    };
                    xhr.open('GET', '../controller/filter_vehicles_by_make.php?make=' + encodeURIComponent(selectedMake), true);
                    xhr.send();
                });
            } else {
                console.error('Element with ID "makeSelect" not found.');
            }
        });
    </script>

</body>
</html>
