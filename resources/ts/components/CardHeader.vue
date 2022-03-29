<template>
    <span class="absolute px-2 py-1 text-sm font-semibold leading-none text-gray-900 rounded-md shadow -top-6 dark:border dark:border-gray-700 bg-gray-50 dark:bg-gray-850 dark:text-gray-200">
        <span class="table-cell p-4">
            <slot />
        </span>
    </span>
</template>

<script lang="ts">
export default {
    name: 'CardHeader',
};
</script>
