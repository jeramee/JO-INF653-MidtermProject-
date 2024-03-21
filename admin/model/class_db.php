<!-- ../model/class_db.php -->
<?php
include_once('database.php');

// Function to get all vehicle classes
function getVehicleClasses($conn) {
    $query = 'SELECT * FROM vehicle_classes';
    
    $statement = $conn->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $results;
}

// Function to check if a duplicate vehicle class exists
function isDuplicateVehicleClass($conn, $class_name) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM vehicle_classes WHERE class_name = :class_name");
        $stmt->bindParam(':class_name', $class_name);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    } catch (PDOException $e) {
        throw $e;
    }
}

// Function to add a new vehicle class
function addVehicleClass($conn, $class_name) {
    try {
        // Check if the class already exists
        if (isDuplicateVehicleClass($conn, $class_name)) {
            throw new PDOException("Duplicate vehicle class.");
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO vehicle_classes (class_name) VALUES (:class_name)");

        // Bind parameters
        $stmt->bindParam(':class_name', $class_name);

        // Execute the statement
        $stmt->execute();
    } catch (PDOException $e) {
        throw $e; // Re-throw the exception for the calling function to handle
    }
}

// Function to remove a vehicle class
function removeVehicleClass($conn, $class_id) {
    $query = 'DELETE FROM vehicle_classes WHERE class_id = :class_id';
    
    $statement = $conn->prepare($query);
    $statement->bindParam(":class_id", $class_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

// Additional functions for managing vehicle classes can be added here...
?>
