<?php

require __DIR__ . '/TLD.php';

class DataBaseOrder implements JsonSerializable {
    private int $id;
    private array $tldList;

    public function __construct(int $id, array $tldList) {
        $this->id = $id;
        $this->tldList = $tldList;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'tldList' => $this->tldList
        ];
    }

    public function getTLDList(): array {
        return $this->tldList;
    }
    
    public function getId(): int {
        return $this->id;
    }
}