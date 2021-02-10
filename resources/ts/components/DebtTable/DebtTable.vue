<template>
    <div class="overflow-x-auto max-w-full rounded">
        <table class="table-auto w-full">
            <DebtTableHeader
                :hacktoberfest="hacktoberfest"
                :show-project-name="showProjectName"
            />
            <tbody class="bg-white rounded-b-lg divide-y divide-smoke">
                <DebtTableRow
                    v-for="project in projects"
                    :key="project"
                    :project="project"
                    :hacktoberfest="hacktoberfest"
                    :show-project-name="showProjectName"
                />
            </tbody>
        </table>
    </div>
</template>
<script lang="ts">
import { PropType } from 'vue';
import { Project } from '../../ozzie.ts';
import DebtTableHeader from './DebtTableHeader';
import DebtTableRow from './DebtTableRow';

export default {
    name: 'DebtTable',
    components: {
        DebtTableHeader,
        DebtTableRow,
    },
    props: {
        projects: {
            type: Object as PropType<Project[]>,
            required: true,
        },
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
