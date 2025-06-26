<?php

class OrderRepo {
    public function addOrder(Order $order): void {
        QueryFunction::addOrder($order);
    }

    public function getAllOrders(): array {
        return QueryFunction::getAllOrders();
    }
}