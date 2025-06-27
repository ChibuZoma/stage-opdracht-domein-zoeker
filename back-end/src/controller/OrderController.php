<?php

header('Content-Type: application/json');

class OrderController {
    private OrderService $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    // POST
    private function addOrder(): void {
        $this->orderService->addOrder();
        http_response_code(204);
    }

    // GET
    private function getAllOrders(): void {
        echo json_encode($this->orderService->getAllOrders());
    }
    
    public function router(): void {
        $request = $_SERVER['REQUEST_URI'];

        switch ($request) {
            case '/api/order':
                $this->routerDefault();
                break;
            case '/api/order/all':
                $this->routerAll();
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Not found']);
                break;
        }
    }

    private function routerDefault(): void {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'POST':
                $this->addOrder();
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                break;
        }
    }

    private function routerAll(): void {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->getAllOrders();
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                break;
        }
    }
}