<!-- ../model/database.php -->
<?php

if (!function_exists('connectToDatabase')) {
    function connectToDatabase() {
        $host = 'localhost';
        $dbname = 'todolist';
        $username = 'root';
        $password = ''; // Use your actual password if set

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }
}

// Usage in other files:
$conn = connectToDatabase();


// Usage in other files:
$conn = connectToDatabase();