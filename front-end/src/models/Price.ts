import type { Product } from "./Product";

export class Price {
    product: Product;

    constructor(product: Product) {
        this.product = product;
    }
}