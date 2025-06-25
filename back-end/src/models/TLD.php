<?php

require __DIR__ . '/Price.php';

class TLD {
    private string $domain;
    private string $status;
    private Price $price;

    public function __construct(string $domain, string $status, Price $price) {
        $this->domain = $domain;
        $this->status = $status;
        $this->price = $price;
    }
}