<!-- create_todolist.php -->
<?php include("../view/header.php") ?>

<section class="todolist-form-container">
    <!-- Your existing content here -->
    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="insert">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required maxlength="20">

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required maxlength="50">

        <button type="submit">Add Item</button>
    </form>
</section>

<?php include("../view/footer.php") ?>
