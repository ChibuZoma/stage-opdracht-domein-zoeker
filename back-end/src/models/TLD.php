<?php

require __DIR__ . '/Price.php';

class TLD implements JsonSerializable {
    private string $domain;
    private string $status;
    private Price $price;

    public function __construct(string $domain, string $status, Price $price) {
        $this->domain = $domain;
        $this->status = $status;
        $this->price = $price;
    }

    public function jsonSerialize(): mixed {
        return [
            'domain' => $this->domain,
            'status' => $this->status,
            'price' => $this->price
        ];
    }
}