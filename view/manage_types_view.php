<!-- ../view/manage_types_view.php -->
<?php
include_once('../model/database.php');
include_once('../model/class_db.php');

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
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching data from the database. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}
?>

<section>
    <!-- Display the dropdown menu for types -->
    <select>
        <option value="#" selected disabled>View All Types</option> <!-- Default value -->
        <?php foreach ($types as $type) : ?>
            <option value="<?php echo $type['vehicle_type']; ?>"><?php echo $type['vehicle_type']; ?></option>
        <?php endforeach; ?>
    </select>
</section>
