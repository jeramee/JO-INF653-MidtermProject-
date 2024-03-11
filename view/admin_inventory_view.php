<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inventory View</title>
    <!-- Include any additional head elements from your original code here... -->
</head>
<body>
    <h1>Admin Inventory View</h1>

    <!-- Display your existing form for adding items -->
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
    <p>Enter the details for the new item and click "Add Item" to add it to your inventory.</p>
    <br><br>
    <p>You can also <a href="../controller/index.php">go back to the ToDo List</a>.</p>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle form submission
        handleFormSubmission();
    }

    // Additional content for your admin inventory view can be added here...

    ?>

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

            // Insert into the database (replace with your actual function)
            // addToDoItem($GLOBALS['conn'], $title, $description, $category_id);

            echo "ToDo Item added successfully!\n"; // Output to the web page

            // Redirect back to admin_inventory_view.php after adding a new item
            header("Location: ../view/admin_inventory_view.php");
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
