<!-- ../view/manage_classes_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
</head>
<body>
    <header>
        <h1>Manage Classes</h1>
    </header>

    <section>
        <!-- Your form for managing classes -->
        <form action="../controller/manage_classes.php" method="post">
            <label for="class_name">Class Name:</label>
            <input type="text" id="class_name" name="class_name" required>
            <button type="submit">Add Class</button>
        </form>
    </section>

    <section>
        <!-- Display the list of classes -->
        <ul>
            <?php if (isset($classes) && is_array($classes)) : ?>
                <?php foreach ($classes as $class) : ?>
                    <li>
                        <?php echo $class['class_name']; ?>
                        <a href='../controller/remove_class.php?id=<?php echo $class['class_id']; ?>'>Remove</a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No classes exist yet.</p>
            <?php endif; ?>
        </ul>
    </section>

    <footer>
        <p>© <?php echo date('Y'); ?> Your Class Management App</p>
    </footer>
</body>
</html>
