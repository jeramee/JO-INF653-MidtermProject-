<!-- ../view/manage_makes_view.php -->
<?php
include_once('../model/database.php');
include_once('../model/class_db.php');

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
    echo "<div style='color: red;'><strong>Error:</strong> An error occurred while fetching data from the database. Please check the database connection and make sure the table exists. <br>";
    echo "Error Message: " . $e->getMessage() . "</div><br>";
}
?>

<!-- Display the dropdown menu for makes -->
<select>
    <option value="#" selected disabled>View All Makes</option> <!-- Default value -->
    <?php foreach ($makes as $make) : ?>
        <option value="<?php echo $make['vehicle_make']; ?>"><?php echo $make['vehicle_make']; ?></option>
    <?php endforeach; ?>
</select>
