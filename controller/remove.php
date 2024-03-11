<!-- remove.php -->
<?php
include('../model/database.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Check if 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $itemId = $_GET['id'];

        // Remove the item from the database based on item_id
        $stmt = $conn->prepare("DELETE FROM todoitems WHERE item_id = :id");
        $stmt->bindParam(':id', $itemId);
        $stmt->execute();

        // Redirect back to index.php after removing the item
        header("Location: index.php");
        exit();
    } else {
        // Redirect to index.php if 'id' parameter is not set
        header("Location: index.php");
        exit();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

