<?php

require __DIR__ . '/../models/Order.php';

class OrderService {
    private OrderRepo $orderRepo;

    public function __construct(OrderRepo $orderRepo) {
        $this->orderRepo = $orderRepo;
    }

    public function addOrder(): void {
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $order = new Order($data);

        $this->orderRepo->addOrder($order);
    }

    public function getAllOrders(): array {
        return $this->orderRepo->getAllOrders();
    }
}