<?php

class Order {
    private array $tldList;

    public function __construct(array $tldList) {
        $this->tldList = $tldList;
    }

    public function getTLDList(): array {
        return $this->tldList;
    }
}