<!-- index_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <script>
        function showErrorPopup() {
            alert("Error inserting data: Duplicate item in that category.");
            // You can use a more sophisticated modal/popup library if needed
        }
    </script>
</head>
<body>
    <h1>ToDo List</h1>

    <!-- Category Filter Form -->
<form action='index.php' method='post'>
    <label for="category_id">Select Category:</label>
    <select name="category_id" id="category_id">
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $categories = getCategories($GLOBALS['conn']);
        foreach ($categories as $category) : ?>
            <option value="<?php echo $category['category_id']; ?>">
                <?php echo $category['category_name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if (count($toDoItems) > 0) {
        foreach ($toDoItems as $item) {
            echo "<div>";
            echo "<span>{$item['category_id']}</span><br>"; // Display ItemNum
            echo "<span>{$item['Title']}</span>";
            echo "<br><br> <!-- Add two line breaks for more space -->";
            echo "<span>{$item['Description']}</span><br><br>";
            echo "<form action='index.php' method='post'>";
            echo "<input type='hidden' name='removeItemNum' value='{$item['category_id']}'>";
            echo "<button type='submit' style='color: red;'>X Remove</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No to-do list items exist yet.</p>";
    }
    ?>

    <!-- Add Item Link -->
    <br><br>
    <a href="../controller/add.php">Add Item</a>
</body>
</html>
