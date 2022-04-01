<template>
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 dark:border dark:border-gray-700">
        <div class="p-4">
            <slot />
        </div>
    </div>
</template>

<script lang="ts">
export default {
    name: 'Card',
};
</script>
