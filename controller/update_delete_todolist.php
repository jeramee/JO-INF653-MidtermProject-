<!-- update_delete_todolist.php -->
<?php include("../view/header.php") 
?>
<?php if (!empty($results)) { ?>
    <section>
        <h2>Update or Delete ToDo Item</h2>
    </section>
    <?php
    foreach ($results as $result) {
        $id = $result["category_id"];
        $title = $result["Title"];
        $description = $result["Description"];
    ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $id ?>">

            <label for="title">Title:</label>
            <input type="text" name="title" value="<?= $title ?>">

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?= $description ?>">

            <button type="submit">Update</button>
        </form>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button type="submit">Delete</button>
        </form>
    <?php } ?>
<?php } else { ?>
    <p>Sorry, No Results!</p>
<?php } ?>
<?php include('../view/status.php') ?><br>
<a href=".">Back to ToDo List</a>
<?php include("../view/footer.php") ?>
