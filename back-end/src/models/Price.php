<?php

require __DIR__ . '/Product.php';

class Price {
    private Product $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }
}
