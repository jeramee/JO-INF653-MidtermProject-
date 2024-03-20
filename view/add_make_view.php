<!-- ../view/add_make_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Vehicle Make List</title>
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

        <h2>Vehicle Make List</h2>

        <!-- Table displaying vehicle makes -->
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP loop to generate rows for each vehicle make -->
                <?php
                // Define array of vehicle makes
                $vehicle_makes = array("Chevy", "Ford", "Cadillac", "Nissan", "Hyundai", "Dodge", "Infiniti", "Buick", "Oldmobile");

                // Loop through each vehicle make and generate table rows
                foreach ($vehicle_makes as $make) {
                    echo "<tr>";
                    echo "<td>$make</td>";
                    echo "<td><a href='#'>Remove</a></td>"; // Change this link to handle removal
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Form to add a new vehicle make -->
        <h2>Add Vehicle Make</h2>
        <form action="#" method="post">
            <label for="new_make">Name:</label>
            <input type="text" id="new_make" name="new_make">
            <input type="submit" value="Add Make">
        </form>

        <!-- Additional links -->
        <p><a href="#">View Full Vehicle List</a></p>
        <p><a href="../view/add_vehicle_view.php">Click here to add a vehicle</a></p>
        <p><a href="../view/add_make_view.php">View/Edit Vehicle Makes</a></p>
        <p><a href="../view/add_type_view.php">View/Edit Vehicle Types</a></p>
        <p><a href="../view/add_class_view.php">View/Edit Vehicle Classes</a></p>
    </div>

</body>
</html>