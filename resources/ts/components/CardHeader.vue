<template>
    <span class="table-row text-sm font-semibold tracking-wide leading-none capitalize border-b-2 border-grey bg-grey-blue-light text-grey-darkest">
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
