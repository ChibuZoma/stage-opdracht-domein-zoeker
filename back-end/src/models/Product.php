<?php

class Product {
    private float $price;
    private string $currency;

    public function __construct(float $price, string $currency) {
        $this->price = $price;
        $this->currency = $currency;
    }
}
