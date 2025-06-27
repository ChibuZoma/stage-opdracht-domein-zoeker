<script setup lang="ts">
import { onMounted, ref, type Ref } from 'vue';
import PageHeader from '../components/PageHeader.vue';
import type { Order } from '../models/Order';

const BACKEND_URL: string = import.meta.env.VITE_APP_BACKEND_URL;

const orderList: Ref<Order[]> = ref([]);
const showTable: Ref<boolean> = ref(false);

onMounted(async () => {
    await fetchOrders();
});

async function fetchOrders(): Promise<void> {
    try {
        const response: Response = await fetch(`${BACKEND_URL}/api/order/all`, {
            method: 'GET',
        });

        if (response.ok) {
            orderList.value = await response.json();
            showTable.value = true;
        }
    } catch (error) {
        console.error("Something went wrong when trying to fetch the data.", error);
    }
}
</script>

<template>
    <PageHeader />
    <h2>Orders</h2>
    <table v-show="showTable">
        <tbody>
            <tr>
                <th>ID</th>
                <th>Order</th>
            </tr>
            <tr v-for="order of orderList" class="border-top border-light">
                <td class="px-2">{{order.id}}</td>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <th>Domain</th>
                                <th>Status</th>
                                <th>Price</th>
                            </tr>
                            <tr v-for="tld of order.tldList">
                                <td>{{tld.domain}}</td>
                                <td>{{tld.status}}</td>
                                <td v-if="tld.price.product.currency === 'EUR'">€{{tld.price.product.price.toFixed(2)}}</td>
                                <td v-else-if="tld.price.product.currency === 'USD'">${{tld.price.product.price.toFixed(2)}}</td>
                                <td v-else-if="tld.price.product.currency === 'CAD'">CA${{tld.price.product.price.toFixed(2)}}</td>
                                <td v-else-if="tld.price.product.currency === 'AUD'">AU${{tld.price.product.price.toFixed(2)}}</td>
                                <td v-else-if="tld.price.product.currency === 'JPY'">¥{{tld.price.product.price.toFixed(2)}}</td>
                                <td v-else-if="tld.price.product.currency === 'KRW'">₩{{tld.price.product.price.toFixed(2)}}</td>
                                <td v-else>-</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</template>
