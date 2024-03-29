<!-- ../controller/manage_classes_view.php -->
<?php
include_once('../view/admin_header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page with Selection Classes</title>
    <link rel="stylesheet" type="text/css" href="../view/css/main.css">
    <script>
        function showErrorPopup() {
            alert("Error inserting data: Duplicate vehicle in that category.");
            // I can use a more sophisticated modal/popup library if needed
        }
    </script>
</head>
<body>
    <div class="container">

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
                    <th>Action</th>
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
<?php
include_once('../view/footer.php');

include_once('../view/troubleshooting_footer.php');


?>