<?php

require __DIR__ . '/Product.php';

class Price implements JsonSerializable {
    private Product $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function jsonSerialize(): mixed {
        return [
            'product' => $this->product
        ];
    }
}
