<?php

require __DIR__ . '/database/PDOConnection.php';
require __DIR__ . '/database/QueryFunction.php';

$request = $_SERVER['REQUEST_URI'];

switch (true) {
    case str_contains($request, '/api/order'):
        require __DIR__ . '/controller/OrderController.php';
        require __DIR__ . '/service/OrderService.php';
        require __DIR__ . '/repository/OrderRepo.php';
        
        $orderRepo = new orderRepo();
        $orderService = new OrderService($orderRepo);
        $orderController = new OrderController($orderService);

        $orderController->router();
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not found']);
        break;
}