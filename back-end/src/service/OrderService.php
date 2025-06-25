<?php

require __DIR__ . '/../models/Order.php';

class OrderService {
    public function addOrder() {
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $order = new Order($data);

        QueryFunction::test();

        return json_encode($order->getTLDList());
    }
}