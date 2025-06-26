<?php

class QueryFunction {
    static function addOrder(Order $order) {
        $pdo = PDOConnection::createConnection();

        $query = "INSERT INTO orders () VALUES ()";
        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute();
            echo "New order created successfully.";

            $orderId = $pdo->lastInsertId();
            $query = "INSERT INTO tlds (domain, status, price, currency, order_id) VALUES (:domain, :status, :price, :currency, :order_id)";
            foreach ($order->getTLDList() as $tld){
                try {
                    $stmt = $pdo->prepare($query);

                    $stmt->bindParam(':domain', $domain, PDO::PARAM_STR);
                    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
                    $stmt->bindParam(':currency', $currency, PDO::PARAM_STR);
                    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);

                    $domain = $tld['domain'];
                    $status = $tld['status'];
                    $price = $tld['price']['product']['price'];
                    $currency = $tld['price']['product']['currency'];
                    
                    $stmt->execute();
                    echo "New tld created successfully.";
                    
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}