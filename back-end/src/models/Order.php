<?php

class Order implements JsonSerializable {
    private array $tldList;

    public function __construct(array $tldList) {
        $this->tldList = $tldList;
    }

    public function jsonSerialize(): mixed {
        return [
            'tldList' => $this->tldList
        ];
    }

    public function getTLDList(): array {
        return $this->tldList;
    }
}