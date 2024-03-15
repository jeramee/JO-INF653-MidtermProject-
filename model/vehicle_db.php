<!-- ../model/vehicle_db.php -->
<?php
include_once('database.php');


// Function to get public inventory of vehicles
function getPublicInventory($conn) {
    try {
        // Modify the query to select appropriate fields from the vehicles table
        $query = 'SELECT year, make.make_name AS make, model, type.type_name AS type, class.class_name AS class, price FROM vehicles
                  INNER JOIN makes ON vehicles.make_id = makes.make_id
                  INNER JOIN types ON vehicles.type_id = types.type_id
                  INNER JOIN classes ON vehicles.class_id = classes.class_id';
        $statement = $conn->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $results;
    } catch (PDOException $e) {
        throw new PDOException("Error fetching public inventory: " . $e->getMessage());
    }
}

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
