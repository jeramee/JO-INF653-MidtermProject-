<?php
// Start the session
session_start();

// Determine the header file to include based on the session variable indicating user login status
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    // User is logged in, include admin header
    $header_path = '../view/admin_header.php';
} else {
    // User is not logged in, include public header
    $header_path = '../view/public_header.php';
}

// Include the selected header file
if (file_exists($header_path)) {
    include_once($header_path);
} else {
    echo "Error: Header file not found.";
}
?>

<!-- HTML content of error.php continues below... -->
