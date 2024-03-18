<!-- ../view/manage_classes_view.php -->
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
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching data from the database. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}
?>

<!-- Display the dropdown menu for classes -->
<select>
    <option value="#" selected disabled>View All Classes</option>
    <?php foreach ($classes as $class) : ?>
        <option value="<?php echo $class['vehicle_class']; ?>"><?php echo $class['vehicle_class']; ?></option>
    <?php endforeach; ?>
</select>
