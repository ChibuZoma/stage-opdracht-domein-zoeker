import type { Price } from "./Price";

export class TLD {
    domain: string;
    status: string;
    price: Price;

    constructor(domain: string, status: string, price: Price) {
        this.domain = domain;
        this.status = status;
        this.price = price;
    }
}