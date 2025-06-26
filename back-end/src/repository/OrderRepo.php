<?php

class OrderRepo {
    public function addOrder(Order $order): void {
        QueryFunction::addOrder($order);
    }
}