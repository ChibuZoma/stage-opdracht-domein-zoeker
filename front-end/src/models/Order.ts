import type { TLD } from "./TLD";

export class Order {
    id: number;
    tldList: TLD[];

    constructor(id: number, tldList: TLD[]) {
        this.id = id;
        this.tldList = tldList;
    }
}