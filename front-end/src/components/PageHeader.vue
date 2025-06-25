<script setup lang="ts">
// onMounted(() => {
//     document.addEventListener("click", (e) => {
//         const header = document.querySelector(".header");
//         if (header && !header.contains(e.target as Node)) {
//             closeMenus();
//         }
//     });
// });
</script>

<template>
    <header class="border-bottom border-light py-2 bg-success">
        <nav>
            <RouterLink to="/" class="btn btn-primary mx-1">Home</RouterLink>
            <RouterLink to="/cart" class="btn btn-primary mx-1">Cart</RouterLink>
        </nav>
    </header>
</template>