<template>
    <span class="table-row border-b-2 border-grey bg-grey-blue-light text-sm font-semibold capitalize leading-none tracking-wide text-grey-darkest">
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
