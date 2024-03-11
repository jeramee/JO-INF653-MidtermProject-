<!-- ../view/manage_types_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Types</title>
</head>
<body>
    <header>
        <h1>Manage Types</h1>
    </header>

    <section>
        <!-- Your form for managing types -->
        <form action="../controller/manage_types.php" method="post">
            <label for="type_name">Type Name:</label>
            <input type="text" id="type_name" name="type_name" required>
            <button type="submit">Add Type</button>
        </form>
    </section>

    <section>
        <!-- Display the list of types -->
        <ul>
            <?php if (isset($types) && is_array($types)) : ?>
                <?php foreach ($types as $type) : ?>
                    <li>
                        <?php echo $type['type_name']; ?>
                        <a href='../controller/remove_type.php?id=<?php echo $type['type_id']; ?>'>Remove</a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No types exist yet.</p>
            <?php endif; ?>
        </ul>
    </section>

    <footer>
        <p>© <?php echo date('Y'); ?> Your Type Management App</p>
    </footer>
</body>
</html>
