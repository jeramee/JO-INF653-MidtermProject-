<!-- index.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('../model/database.php');
include_once('../model/item_db.php');
include_once('../model/category_db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submissions
    if (isset($_POST['removeItemNum'])) {
        $itemNum = $_POST['removeItemNum'];
        echo "Before removing item: $itemNum";

        // Attempt to remove the item
        if (removeToDoItem($GLOBALS['conn'], $itemNum)) {
            echo "Item successfully removed.";
        } else {
            echo "Error removing item.";
        }

        // Redirect to index.php to display the updated list
        header("Location: ../controller/index.php");
        exit();
    }

    if (isset($_POST['category_id'])) {
        // Extract form data
        $category_id = $_POST['category_id'];

        // Redirect to index.php with the selected category
        header("Location: ../controller/index.php?category_id=$category_id");
        exit();
    }
}

// Get categories for the select dropdown
$categories = getCategories($GLOBALS['conn']);

// Get the selected category ID (if any)
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Get to-do items based on the selected category
$toDoItems = getToDoItems($GLOBALS['conn'], $category_id);

// Display the form and to-do list
include('../view/index_view.php');

// Function to handle form submission
function handleFormSubmission() {
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['category_id'])) {
        // Extract form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];

        // Validate and sanitize input
        try {
            // Insert into the database
            addToDoItem($GLOBALS['conn'], $title, $description, $category_id);

            // Redirect back to add_view.php after adding a new item
            header("Location: ../view/add_view.php");
            exit();
        } catch (PDOException $e) {
            // Check for duplicate entry error (error code 1062)
            if ($e->getCode() == '23000' && strpos($e->getMessage(), '1062') !== false) {
                // Display custom error message for duplicate entry
                echo "Error: Duplicate item in that category. Please enter a unique item.";
            } else {
                // Display general error message for other exceptions
                echo "Error inserting data: " . $e->getMessage();
            }
            exit();
        }
    }
}
?>

<!-- index_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../view/css/main.css"> <!-- Include main.css -->
    <title>Add Item</title>
</head>
<body>
    <h1>Add Item</h1>

    <!-- Form elements -->
    <form action="../controller/add.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>">
                    <?php echo $category['category_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <button type="submit">Add Item</button>
    </form>

    <!-- Additional content -->
    <p>Enter the details for the new item and click "Add Item" to add it to your ToDo List.</p>
    <br><br>
    <p>You can also <a href="../controller/index.php">go back to the ToDo List</a>.</p>
</body>
</html>
