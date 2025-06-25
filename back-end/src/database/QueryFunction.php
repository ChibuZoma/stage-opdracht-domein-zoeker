<?php

class QueryFunction {
    static function test() {
        $query = "INSERT INTO orders (tld_id) VALUES (:tld_id)";

        $pdo = PDOConnection::createConnection();
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':tld_id', $tldId, PDO::PARAM_INT);

        // Set values for the parameters
        $tldId = 1;

        try {
            $stmt->execute();
            echo "New order created successfully.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}