<template>
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 dark:border dark:border-gray-700">
        <div class="px-4 py-5">
            <slot />
        </div>
    </div>
</template>

<script lang="ts">
export default {
    name: 'Card',
};
</script>
