<?php

require __DIR__ . '/../models/DataBaseOrder.php';
// require __DIR__ . '/../models/TLD.php';

class QueryFunction {
    static function addOrder(Order $order) {
        $pdo = PDOConnection::createConnection();

        $query = "INSERT INTO orders () VALUES ()";
        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute();

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
                    
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function getAllOrders() {
        $pdo = PDOConnection::createConnection();
        $query = "SELECT id FROM orders";
        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $dbOrderList = [];
            foreach ($result as $id) {
                $query = "SELECT domain, status, price, currency, order_id
                    FROM tlds AS t
                    JOIN orders AS o
                    ON t.order_id = o.id
                    WHERE o.id = (:order_id)";

                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':order_id', $id["id"], PDO::PARAM_INT);
                
                try {
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $tldList = [];
                    foreach ($result as $item) {
                        $tld = new TLD(
                            $item["domain"],
                            $item["status"],
                            new Price(
                                new Product(
                                    $item["price"],
                                    $item["currency"]
                                )
                            )
                        );
                        array_push($tldList, $tld);
                    }
                    
                    if (count($tldList) > 0) {
                        $dbOrder = new DataBaseOrder($id["id"], $tldList);
                        array_push($dbOrderList, $dbOrder);
                    }

                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }

            return $dbOrderList;
                
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}