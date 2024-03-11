<!-- ../model/category_db.php -->
<?php

include("database.php");

// Function to get categories from the database
function getCategories($conn) {
    $query = 'SELECT * FROM categories';
    $statement = $conn->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
    $statement->closeCursor();
    return $categories;
}

function getCategoryName($conn, $category_id) {
    $query = 'SELECT * FROM categories WHERE category_id = :category_id';
    $statement = $conn->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $category = $statement->fetch();
    $statement->closeCursor();

    $category_name = $category['category_name'];
    return $category_name;
}

function getCategoryByName($conn, $categoryName) {
    $query = 'SELECT * FROM categories WHERE category_name = :category_name';
    $statement = $conn->prepare($query);
    $statement->bindValue(':category_name', $categoryName);
    $statement->execute();
    $category = $statement->fetch();
    $statement->closeCursor();

    return $category;
}


function addCategory($conn, $category_name) {
    try {
        // Log statement for debugging
        echo "Before addCategory function call"; 

        $query = 'INSERT INTO categories (category_name) VALUES (:category_name)';
        
        $statement = $conn->prepare($query);
        $statement->bindValue(':category_name', $category_name);
        $statement->execute();
        $statement->closeCursor();

        // Log statement for debugging
        echo "After addCategory function call";
    } catch (PDOException $e) {
        // Log any errors
        echo "Error adding category: " . $e->getMessage();
    }
}


function removeCategory($conn, $category_id) {
    $query = 'DELETE FROM categories WHERE category_id = :category_id';
    
    $statement = $conn->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $statement->closeCursor();
}
?>
