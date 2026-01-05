    <?php
        
    try {
        $servername = "localhost";
        $username = "root";       // Replace with your database username
        $password = "";           // Replace with your database password
        $dbname = "my_php_game";  // Replace with your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Optional: Set charset to handle special characters properly
        $conn->set_charset("utf8mb4");

    } catch (mysqli_sql_exception $e) {
        // If connection fails, show a clear error message and stop execution
        die("Database connection failed: " . $e->getMessage());
    }
    ?>