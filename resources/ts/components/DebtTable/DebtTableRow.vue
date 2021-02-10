<template>
    <tr>
        <td
            v-if="showProjectName"
            class="p-4"
        >
            <InertiaLink
                class="text-indigo no-underline p-2 -mx-2"
                :href="'/inertia/projects/' + project.namespace + '/' + project.name"
                method="get"
            >
                {{ project.namespace }}/{{ project.name }}
            </InertiaLink>
        </td>
        <td class="text-black-lightest p-4">
            {{ project.debt_score }}
        </td>
        <td class="text-black-lightest p-4">
            <img :src="`data:image/jpeg;base64, ${project.debt_score_graph}`">
        </td>
        <td class="text-black-lightest p-4">
            {{ project.old_pull_requests_count }}
        </td>
        <td class="text-black-lightest p-4">
            {{ project.old_issues_count }}
        </td>
        <td class="text-black-lightest p-4">
            {{ project.pull_requests_count }}
        </td>
        <td class="text-black-lightest p-4">
            {{ project.issues_count }}
        </td>
        <td
            v-if="hacktoberfest"
            class="p-4"
        >
            <a
                class="text-indigo no-underline p-2 -mx-2"
                :href="'https://github.com/' + project.namespace + '/' +project.name + '/labels/hacktoberfest'"
                target="_blank"
            >
                {{ project.hacktoberfestIssues }}
            </a>
        </td>
    </tr>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Project } from '../../ozzie.d.ts';

export default {
    name: 'DebtTableRow',
    props: {
        project: {
            type: Object as PropType<Project>,
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
