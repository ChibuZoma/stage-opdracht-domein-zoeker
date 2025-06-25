<script setup lang="ts">
import { onMounted, ref, type Ref } from 'vue';
import { RootDomain } from '../models/RootDomain.ts';
import type { TLD } from '../models/TLD';
import PageHeader from '../components/PageHeader.vue';

const MINTY_API_URL: string = import.meta.env.VITE_APP_MINTY_API_URL;
const extensionList: string[] = ["com", "nl", "be", "fr", "de", "ch", "pl", "jp", "kr", "io", "net", "gov"];

const cart: Ref<TLD[]> = ref([]);
const tldList: Ref<TLD[]> = ref([]);
const domainName: Ref<string> = ref("");
const rootDomainList: Ref<RootDomain[]> = ref([]);
const showTable: Ref<boolean> = ref(false);

onMounted(() => {
    updateCartFromSession();
});

async function submitDomainName(): Promise<void> {
    populateRootDomainList();
    await fetchTLDs();
}

async function fetchTLDs(): Promise<void> {
    try {
        const response: Response = await fetch(`${MINTY_API_URL}/domains/search?with_price=true`, {
            method: 'POST',
            headers: {
                'Authorization': 'Basic 072dee999ac1a7931c205814c97cb1f4d1261559c0f6cd15f2a7b27701954b8d',
                "Content-Type": "application/json"
            },
            body: JSON.stringify(rootDomainList.value)
        });

        if (response.ok) {
            tldList.value = await response.json();
            showTable.value = true;
        }
    } catch (error) {
        console.error("Something went wrong when trying to fetch the data.", error);
    }
}

function populateRootDomainList(): void {
    rootDomainList.value = [];
    for (const extension of extensionList) {
        const rootDomain: RootDomain = new RootDomain(domainName.value, extension);
        rootDomainList.value.push(rootDomain);
    }
}

function updateCartFromSession(): void {
    const sessionCart: string | null = sessionStorage.getItem("cart");

    if (sessionCart === null) {
        cart.value = [];
    } else {
        cart.value = JSON.parse(sessionCart);
    }
}

function cartContainsDomain(tld: TLD): boolean {
    return cart.value.find(t => t.domain === tld.domain) !== undefined;
}

function addToCart(tld: TLD): void {
    if (!cartContainsDomain(tld)) {
        cart.value.push(tld);
        sessionStorage.setItem("cart", JSON.stringify(cart.value));
    }
}
</script>

<template>
    <PageHeader />
    <div>
        <input type="text" v-model="domainName">
        <button @click="submitDomainName" class="btn btn-success">Submit</button>
    </div>
    <div>
        <table v-show="showTable">
            <tbody>
                <tr>
                    <th>Domain</th>
                    <th>Status</th>
                    <th>Price</th>
                </tr>
                <tr v-for="tld of tldList">
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
                        <button v-if="cartContainsDomain(tld)" class="btn btn-warning disabled">Add To Cart</button>
                        <button v-else-if="tld.status === 'free'" @click="addToCart(tld)" class="btn btn-success">Add To Cart</button>
                        <button v-else class="btn btn-danger disabled">Add To Cart</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
