<?php

header('Content-Type: application/json');

class OrderController {
    private OrderService $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }
    
    public function router() {
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

    // POST
    private function addOrder(): void {
        $this->orderService->addOrder();
    }
}