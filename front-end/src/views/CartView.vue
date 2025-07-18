<script setup lang="ts">
import { onMounted, ref, type Ref } from 'vue';
import type { TLD } from '../models/TLD';
import PageHeader from '../components/PageHeader.vue';

const BACKEND_URL: string = import.meta.env.VITE_APP_BACKEND_URL;
const btwPercent: number = 21;

const cart: Ref<TLD[]> = ref([]);
const showTable: Ref<boolean> = ref(false);
const orderIsAdded: Ref<boolean> = ref(false);
const checkOutIsClicked: Ref<boolean> = ref(false);

const subTotal: Ref<number> = ref(0);
const btw: Ref<number> = ref(0);
const total: Ref<number> = ref(0);

onMounted(() => {
    updateCartFromSession();
});

function updateCartFromSession(): void {
    const sessionCart: string | null = sessionStorage.getItem("cart");

    if (sessionCart === null) {
        cart.value = [];
    } else {
        cart.value = JSON.parse(sessionCart);
        showTable.value = true;
        calculateFinalPrices();
    }
}

function removeTLDFromCart(tld: TLD): void {
    const index: number = cart.value.findIndex(t => t.domain === tld.domain);
    if (index > -1) {
        cart.value.splice(index, 1);
        sessionStorage.setItem("cart", JSON.stringify(cart.value));
        calculateFinalPrices();
    }
}

function calculateFinalPrices(): void {
    calculateTotal();
    calculateBTW();
    calculateSubTotal();
}

function calculateSubTotal(): void {
    subTotal.value = parseFloat((total.value - btw.value).toFixed(2));
}

function calculateBTW(): void {
    btw.value = parseFloat((total.value / (btwPercent + 100) * btwPercent).toFixed(2));
}

function calculateTotal(): void {
    let totalLocal: number = 0;
    for (const tld of cart.value) {
        totalLocal += tld.price.product.price;
    }

    total.value = parseFloat(totalLocal.toFixed(2));
}

function resetCart(): void {
    sessionStorage.setItem("cart", JSON.stringify([]));
    updateCartFromSession();
}

async function checkOut(): Promise<void> {
    checkOutIsClicked.value = true;

    try {
        const response: Response = await fetch(`${BACKEND_URL}/api/order`, {
            method: 'POST',
            body: JSON.stringify(cart.value)
        });

        if (response.ok) {
            console.log("Order added successfully");
            orderIsAdded.value = true;
            resetCart();
        }
    } catch (error) {
        console.error("Something went wrong when trying to post the data.", error);
    }
}
</script>

<template>
    <PageHeader />
    <h2>Cart</h2>
    <h2 v-if="orderIsAdded === true">Order Added Successfully</h2>
    <table>
        <tbody>
            <tr>
                <th>Domain</th>
                <th>Status</th>
                <th>Price</th>
            </tr>
            <tr v-for="tld of cart">
                <td>{{tld.domain}}</td>
                <td>{{tld.status}}</td>
                <td v-if="tld.price.product.currency === 'EUR'">€{{tld.price.product.price.toFixed(2)}}</td>
                <td v-else-if="tld.price.product.currency === 'USD'">${{tld.price.product.price.toFixed(2)}}</td>
                <td v-else-if="tld.price.product.currency === 'CAD'">CA${{tld.price.product.price.toFixed(2)}}</td>
                <td v-else-if="tld.price.product.currency === 'AUD'">AU${{tld.price.product.price.toFixed(2)}}</td>
                <td v-else-if="tld.price.product.currency === 'JPY'">¥{{tld.price.product.price.toFixed(2)}}</td>
                <td v-else-if="tld.price.product.currency === 'KRW'">₩{{tld.price.product.price.toFixed(2)}}</td>
                <td v-else>-</td>
                <td>
                    <button class="btn btn-danger" @click="removeTLDFromCart(tld)">Remove</button>
                </td>
            </tr>
            <tr class="border-bottom border-light"></tr>
            <tr>
                <td>Subtotal</td>
                <td></td>
                <td>€{{ subTotal.toFixed(2) }}</td>
            </tr>
            <tr>
                <td>BTW</td>
                <td>{{btwPercent}}%</td>
                <td>€{{ btw.toFixed(2) }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td></td>
                <td>€{{ total.toFixed(2) }}</td>
                <button v-if="cart.length > 0 && !checkOutIsClicked" @click="checkOut" class="btn btn-success">Check Out</button>
                <button v-else class="btn btn-success disabled">Check Out</button>
            </tr>
        </tbody>
    </table>
</template>
