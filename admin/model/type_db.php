<!-- ../model/type_db.php -->
<?php
include_once('database.php');

// Function to get all vehicle types
function getVehicleTypes($conn) {
    $query = 'SELECT * FROM vehicle_types';
    
    $statement = $conn->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $results;
}

// Function to check if a duplicate vehicle type exists
function isDuplicateVehicleType($conn, $type_name) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM vehicle_types WHERE type_name = :type_name");
        $stmt->bindParam(':type_name', $type_name);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    } catch (PDOException $e) {
        throw $e;
    }
}

// Function to add a new vehicle type
function addVehicleType($conn, $type_name) {
    try {
        // Check if the type already exists
        if (isDuplicateVehicleType($conn, $type_name)) {
            throw new PDOException("Duplicate vehicle type.");
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO vehicle_types (type_name) VALUES (:type_name)");

        // Bind parameters
        $stmt->bindParam(':type_name', $type_name);

        // Execute the statement
        $stmt->execute();
    } catch (PDOException $e) {
        throw $e; // Re-throw the exception for the calling function to handle
    }
}

// Function to remove a vehicle type
function removeVehicleType($conn, $type_id) {
    $query = 'DELETE FROM vehicle_types WHERE type_id = :type_id';
    
    $statement = $conn->prepare($query);
    $statement->bindParam(":type_id", $type_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

// Additional functions for managing vehicle types can be added here...
?>
