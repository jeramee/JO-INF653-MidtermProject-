<!-- ../view/manage_makes_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Makes</title>
</head>
<body>
    <header>
        <h1>Manage Makes</h1>
    </header>

    <section>
        <!-- Your form for managing makes -->
        <form action="../controller/manage_makes.php" method="post">
            <label for="make_name">Make Name:</label>
            <input type="text" id="make_name" name="make_name" required>
            <button type="submit">Add Make</button>
        </form>
    </section>

    <section>
        <!-- Display the list of makes -->
        <ul>
            <?php if (isset($makes) && is_array($makes)) : ?>
                <?php foreach ($makes as $make) : ?>
                    <li>
                        <?php echo $make['make_name']; ?>
                        <a href='../controller/remove_make.php?id=<?php echo $make['make_id']; ?>'>Remove</a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No makes exist yet.</p>
            <?php endif; ?>
        </ul>
    </section>

</body>
</html>
