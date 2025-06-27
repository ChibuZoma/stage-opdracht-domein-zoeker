<?php
class PDOConnection {
    static function createConnection(): PDO {
        $servername = "localhost";  // MySQL server
        $username = "root";         // MySQL username
        $password = "";             // MySQL password (empty in this example)
        $dbname = "domein_zoeker";  // The database you want to connect to

        try {
            // Create connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
