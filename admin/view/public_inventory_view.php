<!-- ../view/public_inventory_view.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Include the admin header
    require_once "../view/admin_header.php";
} catch (Exception $e) {
    echo "Error loading admin header: " . $e->getMessage();
}

?>
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
    <?php include('public_header.php'); ?>

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

    </tbody>
</table>
<!-- Include the footer -->
<?php require "../view/footer.php"; ?>

</body>
</html>
