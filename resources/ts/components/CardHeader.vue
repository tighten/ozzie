<template>
    <span class="absolute px-2 py-1 text-sm font-semibold leading-none text-gray-900 bg-white rounded-md shadow -top-5 dark:border dark:border-gray-700 dark:bg-gray-850 dark:text-gray-200">
        <span class="block px-2 py-2">
            <slot />
        </span>
    </span>
</template>

<script lang="ts">
export default {
    name: 'CardHeader',
};
</script>
