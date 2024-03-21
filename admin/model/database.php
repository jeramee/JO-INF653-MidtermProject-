<!-- ../model/database.php -->
<?php
if (!function_exists('connectToDatabase')) {
    function connectToDatabase() {
        $host = '34.42.41.35'; // Replace with the public IP address of your Cloud SQL instance
        $dbname = 'zippyusedautos'; // Updated database name
        $username = 'jeramee'; // Replace with your actual username
        $password = '>??mzY6Na8VZEuT'; // Replace with your actual password

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
?>

