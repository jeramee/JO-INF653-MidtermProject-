<!-- ../model/vehicle_db.php -->
<?php
include_once('database.php');

function getVehicles($conn, $orderBy = 'price', $make = null, $type = null, $class = null) {
    // Your code to fetch vehicles based on parameters
    // Adjust the SQL query based on your database structure and requirements
    $query = 'SELECT * FROM vehicles';

    // Add conditions based on parameters
    if ($make !== null) {
        $query .= ' WHERE make = :make';
    }
    if ($type !== null) {
        $query .= ' AND type = :type';
    }
    if ($class !== null) {
        $query .= ' AND class = :class';
    }

    // Add order by clause
    $query .= ' ORDER BY ' . $orderBy;

    // Prepare and execute the statement
    $statement = $conn->prepare($query);

    // Bind parameters
    if ($make !== null) {
        $statement->bindParam(':make', $make);
    }
    if ($type !== null) {
        $statement->bindParam(':type', $type);
    }
    if ($class !== null) {
        $statement->bindParam(':class', $class);
    }

    $statement->execute();

    // Fetch and return results
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $results;
}

function deleteVehicle($conn, $vehicleId) {
    // Your code to delete a vehicle
    // Adjust the SQL query based on your database structure
    $query = 'DELETE FROM vehicles WHERE vehicle_id = :vehicle_id';

    // Prepare and execute the statement
    $statement = $conn->prepare($query);
    $statement->bindParam(':vehicle_id', $vehicleId, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

// Additional functions for managing vehicles can be added here...
?>
