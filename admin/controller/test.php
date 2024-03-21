<!-- ../controller/test.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zippy Used Autos - Public Page</title>
</head>
<body>
    <h1>Zippy Used Autos - Public Page</h1>

    <!-- Navigation links -->
    <ul>
        <li><a href="#">View All Makes</a></li>
        <li><a href="#">View All Types</a></li>
        <li><a href="#">View All Classes</a></li>
    </ul>

    <!-- Sorting options -->
    <form action="#" method="post">
        <label for="sorting">Sorted by:</label>
        <select name="sorting" id="sorting">
            <option value="price">Price</option>
            <option value="year">Year</option>
        </select>
        <input type="submit" value="Submit">
    </form>

    <!-- Vehicle table -->
    <table border="1">
        <thead>
            <tr>
                <th>Year</th>
                <th>Make</th>
                <th>Model</th>
                <th>Type</th>
                <th>Class</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
        
        </tbody>
    </table>
</body>
</html>
