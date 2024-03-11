<?php
// Ensure error reporting is enabled for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include_once('../model/database.php');
include_once('../model/item_db.php');
include_once('../model/category_db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['description'])) {
    // Extract form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Check if category_id is set
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;

    // Check if new_category is set
    $new_category = isset($_POST['new_category']) ? $_POST['new_category'] : null;

    // Validate and sanitize input
    try {
        // Check if a new category is provided
        if (!empty($new_category)) {
            // Insert a new category
            addCategory($GLOBALS['conn'], $new_category);

            // Fetch the newly added category ID
            $category = getCategoryByName($GLOBALS['conn'], $new_category);
            $category_id = $category['category_id'];
        }

        // Insert into the database
        addToDoItem($GLOBALS['conn'], $title, $description, $category_id);

        // Redirect back to add_view.php after adding a new item
        header("Location: ../view/add_view.php");
        exit();
    } catch (PDOException $e) {
        echo "Error inserting data: " . $e->getMessage();
        exit();
    }
}

// Fetch categories for dropdown menu
$categories = getCategories($GLOBALS['conn']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
</head>
<body>
    <h1>Add Item</h1>

    <!-- Form elements -->
    <form action="/JO-INF653-react-todo-Backend-2/JO-INF653-react-todo-Backend-2/controller/add.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>

        <!-- Dropdown for existing categories -->
        <label for="category_id">Select Existing Category:</label>
        <select name="category_id" id="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>">
                    <?php echo $category['category_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <!-- Input for new category -->
        <label for="new_category">New Category:</label>
        <input type="text" id="new_category" name="new_category">
        <br>

        <button type="submit">Add Item</button>
    </form>

    <!-- Additional content -->
    <p>Enter the details for the new item and click "Add Item" to add it to your ToDo List.</p>
    <br><br>
    <p>You can also <a href="/JO-INF653-react-todo-Backend-2/JO-INF653-react-todo-Backend-2/controller/index.php">go back to the ToDo List</a>.</p>
</body>
</html>
