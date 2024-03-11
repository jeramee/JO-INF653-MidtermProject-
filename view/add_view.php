<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('../model/database.php');
include_once('../model/item_db.php');
include_once('../model/category_db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    handleFormSubmission();
}

// Get categories for the select dropdown
$categories = getCategories($GLOBALS['conn']);

// Display the form
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

<?php
// Function to handle form submission
function handleFormSubmission() {
    echo "Handling form submission...\n"; // Output to the web page

    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['category_id'])) {
        // Extract form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];

        // Validate and sanitize input
        try {
            echo "Adding ToDo Item...\n"; // Output to the web page

            // Insert into the database
            addToDoItem($GLOBALS['conn'], $title, $description, $category_id);

            echo "ToDo Item added successfully!\n"; // Output to the web page

            // Redirect back to add_view.php after adding a new item
            header("Location: ../view/add_view.php");
            exit();
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage(); // Output to the web page
            exit();
        }
    } else {
        echo "Form data is incomplete.\n"; // Output to the web page
    }
}
?>
