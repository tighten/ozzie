<template>
    <table class="table-auto w-full border border-grey">
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
        <tbody class="bg-white divide-y divide-smoke">
            <tr
                v-for="project in projects"
                :key="project.id"
            >
                <td
                    v-if="showProjectName"
                    class="p-4"
                >
                    <InertiaLink
                        class="text-indigo no-underline p-2 -mx-2"
                        :href="$route('projects.show', {
                            namespace: project.namespace,
                            name: project.name,
                        })"
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
        </tbody>
    </table>
</template>
<script lang="ts">
import { PropType } from 'vue';
import { Project } from '../ozzie.ts';

export default {
    name: 'DebtTable',
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
