<template>
    <thead class="bg-grey-blue-light border-grey border-b-2 text-left">
        <tr>
            <th
                v-if="showProjectName"
                class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4"
            >
                Project Name
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
                Debt Score
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
                Debt Score Graph
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
                Old Prs
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
                Old Issues
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
                Prs
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
                Issues
            </th>
            <th
                v-if="hacktoberfest"
                class="text-xs p-4"
            >
                🎃
            </th>
        </tr>
    </thead>
</template>
<script lang="ts">
export default {
    name: 'DebtTableHeader',
    props: {
        hacktoberfest: {
            type: Boolean,
            default: false,
        },
        showProjectName: {
            type: Boolean,
            default: true,
        },
    },
};
</script>
