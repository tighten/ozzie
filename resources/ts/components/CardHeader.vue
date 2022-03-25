<template>
    <span class="table-row border-b-2 border-gray bg-gray-blue-light text-sm font-semibold capitalize leading-none tracking-wide text-gray-darkest">
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
