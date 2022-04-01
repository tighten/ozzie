<template>
    <TableContainer class="w-full">
        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-850">
                <tr>
                    <th v-if="showProjectName" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                        Project Name
                    </th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                        Debt Score
                    </th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                        Debt Score Graph
                    </th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                        Old Prs
                    </th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                        Old Issues
                    </th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                        Prs
                    </th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                        Issues
                    </th>
                    <th
                        v-if="hacktoberfest"
                        class="hidden p-4 text-xs md:table-cell">
                        🎃
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300 dark:bg-gray-800 dark:divide-gray-700">
                <tr
                    v-for="project in projects"
                    :key="project.id"
                    :class="linkProjects ? ['hover:bg-indigo-50 dark:hover:bg-indigo-900/30', 'cursor-pointer'] : []"
                    @click="linkProjects ? $inertia.visit(ozzieProjectUrl(project.packagist_name)) : null">
                    <td
                        v-if="showProjectName"
                        class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                        <InertiaLink
                            class="text-indigo-600 no-underline dark:text-indigo-400"
                            :href="ozzieProjectUrl(project.packagist_name)"
                            method="get">
                            {{ project.namespace }}/{{ project.name }}
                        </InertiaLink>
                    </td>
                    <td class="p-4 text-gray-900 dark:text-gray-200">
                        <div class="flex items-baseline">
                            {{ project.debt_score }}
                        </div>
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                        <img
                            :src="`data:image/jpeg;base64, ${project.debt_score_graph}`"
                            :alt="`debt score graph for project ${project.namespace}/${project.name}`"
                            width="80"
                            height="20">
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                        {{ project.old_pull_requests_count }}
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                        {{ project.old_issues_count }}
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                        {{ project.pull_requests_count }}
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                        {{ project.issues_count }}
                    </td>

                    <td
                        v-if="hacktoberfest"
                        class="hidden p-4 md:table-cell">
                        <a
                            class="p-2 -mx-2 text-indigo-600 no-underline dark:text-indigo-400"
                            :href="'https://github.com/' + project.namespace + '/' + project.name + '/labels/hacktoberfest'"
                            target="_blank">
                            {{ project.hacktoberfest_issues }}
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </TableContainer>
</template>
<script lang="ts">
import { PropType } from 'vue';
import { Project } from '@/ozzie';
import { ozzieProjectUrl } from '@/functions/url';
import TableContainer from '@/ui/TableContainer.vue';

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
        linkProjects: {
            type: Boolean,
            default: true,
        },
    },
    methods: {
        debtScoreClass(debtScore: number): string {
            if (debtScore > 5) {
                return 'bg-red';
            }
            if (debtScore > 1) {
                return 'bg-orange';
            }
            return '';
        },
        ozzieProjectUrl,
    },
    components: {
        TableContainer,
    }
};
</script>
