<?php
// Initialize variables
$selectedType = isset($_GET['type']) ? $_GET['type'] : null;
$selectedMake = isset($_GET['make']) ? $_GET['make'] : null;
$selectedClass = isset($_GET['class']) ? $_GET['class'] : null;
$makes = [];
$classes = [];
$types = [];
$vehicles = [];
$filteredVehicles = []; // Initialize an empty array

// Now I can include the public_header.php file
include_once('./view/public_header.php');

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zippy Used Autos - Public Page</title>
    
</head>
<body>


    <!-- Navigation links -->
    <ul>
        <li>
            <!-- Display the dropdown menu for types -->
            <select id="typeSelect">
                <option value="#" <?php if ($selectedType === null) echo 'selected'; ?>>View All Types</option> <!-- Default value -->
                <?php foreach ($types as $type) : ?>
                    <option value="<?php echo $type['type_id']; ?>" <?php if ($selectedType === $type['type_id'] || (isset($_GET['type']) && $_GET['type'] == $type['type_id'])) echo 'selected'; ?>><?php echo $type['type_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </li>
        <li>
            <!-- Display the dropdown menu for makes -->
            <select id="makeSelect">
                <option value="#" <?php if ($selectedMake === null) echo 'selected'; ?>>View All Makes</option> <!-- Default value -->
                <?php foreach ($makes as $make) : ?>
                    <option value="<?php echo $make['make_id']; ?>" <?php if ($selectedMake === $make['make_id'] || (isset($_GET['make']) && $_GET['make'] == $make['make_id'])) echo 'selected'; ?>><?php echo $make['make_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </li>
        <li>
            <!-- Display the dropdown menu for classes -->
            <form id="classForm">
                <select id="classSelect">
                    <option value="#" <?php if ($selectedClass === null) echo 'selected'; ?>>View All Classes</option>
                    <?php foreach ($classes as $class) : ?>
                        <option value="<?php echo $class['class_id']; ?>" <?php if ($selectedClass === $class['class_id'] || (isset($_GET['class']) && $_GET['class'] == $class['class_id'])) echo 'selected'; ?>><?php echo $class['class_name']; ?></option>
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
                </tr>
            </thead>
            <tbody>
                <!-- Filtered vehicles will be loaded dynamically based on the selected class -->
                <?php foreach ($filteredVehicles as $vehicle) : ?>
                    <tr>
                        <td><?php echo $vehicle['vehicle_year']; ?></td>
                        <td><?php echo getMakeNameById($vehicle['make_id'], $makes); ?></td>
                        <td><?php echo $vehicle['vehicle_model']; ?></td>
                        <td><?php echo getTypeNameById($vehicle['type_id'], $types); ?></td>
                        <td><?php echo getClassNameById($vehicle['class_id'], $classes); ?></td>
                        <td>$<?php echo $vehicle['vehicle_price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

<?php
include_once('./view/footer.php');


?>
