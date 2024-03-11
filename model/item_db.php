<?php
include("database.php");

function getToDoItems($conn, $category_id = null) {
    $query = 'SELECT todoitems.*, categories.category_name 
              FROM todoitems 
              LEFT JOIN categories ON todoitems.category_id = categories.category_id';
              
    if ($category_id !== null) {
        $query .= ' WHERE todoitems.category_id = :category_id';
    }

    $statement = $conn->prepare($query);
    
    if ($category_id !== null) {
        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    }

    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $results;
}

// Function to check if a duplicate item exists in the category
function isDuplicateItem($conn, $title, $category_id) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM todoitems WHERE Title = :title AND category_id = :category_id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    } catch (PDOException $e) {
        throw $e;
    }
}

// Function to insert a to-do item
function addToDoItem($conn, $title, $description, $category_id) {
    try {
        // Check if the item already exists in the category
        if (isDuplicateItem($conn, $title, $category_id)) {
            throw new PDOException("Duplicate item in that category.");
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO todoitems (Title, Description, category_id) VALUES (:title, :description, :category_id)");

        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);

        // Execute the statement
        $stmt->execute();
    } catch (PDOException $e) {
        throw $e; // Re-throw the exception for the calling function to handle
    }
}

function removeToDoItem($conn, $itemNum) {
    $query = 'DELETE FROM todoitems WHERE item_id = :item_id';
    
    $statement = $conn->prepare($query);
    $statement->bindParam(":item_id", $itemNum, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

// item_db.php

/* function getCategories($conn) {
        try {
        $query = 'SELECT * FROM categories';
        $statement = $conn->prepare($query);
        $statement->execute();
        $categories = $statement->fetchAll();
        $statement->closeCursor();
        return $categories;
    } catch (PDOException $e) {
        echo "Error getting categories: " . $e->getMessage();
        exit();
    }
}
*/

?>
