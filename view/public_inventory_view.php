<!-- ../view/public_inventory_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing public_inventory_view.php code for the HTML head... -->
    <!-- Include any additional head elements from your original code here... -->

    <!-- Include common styles or scripts if needed -->
    <link rel="stylesheet" href="path/to/common.css">
    <script src="path/to/common.js"></script>
</head>
<body>
    <!-- Include the header -->
    <?php include('header.php'); ?>

    <header>
        <h1>Public Inventory</h1>
    </header>

    <section>
        <!-- Include the content for managing classes -->
        <?php include('manage_classes_view.php'); ?>
    </section>

    <section>
        <!-- Include the content for managing makes -->
        <?php include('manage_makes_view.php'); ?>
    </section>

    <section>
        <!-- Include the content for managing types -->
        <?php include('manage_types_view.php'); ?>
    </section>

    <!-- Include the footer -->
    <?php include('footer.php'); ?>
</body>
</html>
