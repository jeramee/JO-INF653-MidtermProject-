<?php
include_once('database.php');

// Function to get all vehicle makes
function getMakes($conn) {
    $query = 'SELECT * FROM vehicle_makes';
    
    $statement = $conn->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $results;
}

// Function to get the name of a specific make by ID
function getMakeName($conn, $makeId) {
    $query = 'SELECT make_name FROM vehicle_makes WHERE make_id = :make_id';
    
    $statement = $conn->prepare($query);
    $statement->bindParam(':make_id', $makeId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchColumn();
    $statement->closeCursor();

    return $result;
}

// Function to check if a duplicate make exists
function isDuplicateMake($conn, $makeName) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM vehicle_makes WHERE make_name = :make_name");
        $stmt->bindParam(':make_name', $makeName);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    } catch (PDOException $e) {
        throw $e;
    }
}

// Function to add a new vehicle make
function addMake($conn, $makeName) {
    try {
        // Check if the make already exists
        if (isDuplicateMake($conn, $makeName)) {
            throw new PDOException("Duplicate vehicle make.");
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO vehicle_makes (make_name) VALUES (:make_name)");

        // Bind parameters
        $stmt->bindParam(':make_name', $makeName);

        // Execute the statement
        $stmt->execute();
    } catch (PDOException $e) {
        throw $e; // Re-throw the exception for the calling function to handle
    }
}

// Function to remove a vehicle make
function removeMake($conn, $makeId) {
    $query = 'DELETE FROM vehicle_makes WHERE make_id = :make_id';
    
    $statement = $conn->prepare($query);
    $statement->bindParam(":make_id", $makeId, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

// Additional functions for managing vehicle makes can be added here...
?>
