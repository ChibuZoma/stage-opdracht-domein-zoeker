<?php

class Product implements JsonSerializable {
    private float $price;
    private string $currency;

    public function __construct(float $price, string $currency) {
        $this->price = $price;
        $this->currency = $currency;
    }

    public function jsonSerialize(): mixed {
        return [
            'price' => $this->price,
            'currency' => $this->currency
        ];
    }
}
