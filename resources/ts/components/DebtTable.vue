<template>
    <table class="mt-6 w-full table-auto border border-gray">
        <thead class="border-b-2 border-gray bg-gray-blue-light text-left">
            <tr>
                <th
                    v-if="showProjectName"
                    class="p-4 text-xs font-bold uppercase leading-none tracking-wide text-gray-darkest">
                    Project Name
                </th>
                <th class="p-4 text-xs font-bold uppercase leading-none tracking-wide text-gray-darkest">
                    Debt Score
                </th>
                <th class="hidden p-4 text-xs font-bold uppercase leading-none tracking-wide text-gray-darkest md:table-cell">
                    Debt Score Graph
                </th>
                <th class="hidden p-4 text-xs font-bold uppercase leading-none tracking-wide text-gray-darkest md:table-cell">
                    Old Prs
                </th>
                <th class="hidden p-4 text-xs font-bold uppercase leading-none tracking-wide text-gray-darkest md:table-cell">
                    Old Issues
                </th>
                <th class="hidden p-4 text-xs font-bold uppercase leading-none tracking-wide text-gray-darkest md:table-cell">
                    Prs
                </th>
                <th class="hidden p-4 text-xs font-bold uppercase leading-none tracking-wide text-gray-darkest md:table-cell">
                    Issues
                </th>
                <th
                    v-if="hacktoberfest"
                    class="hidden p-4 text-xs md:table-cell">
                    🎃
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-smoke bg-white">
            <tr
                v-for="project in projects"
                :key="project.id"
                :class="linkProjects ? ['hover:bg-indigo-50', 'cursor-pointer'] : []"
                @click="linkProjects ? $inertia.visit(ozzieProjectUrl(project.packagist_name)) : null">
                <td
                    v-if="showProjectName"
                    class="p-4">
                    <InertiaLink
                        class="text-indigo-600 no-underline"
                        :href="ozzieProjectUrl(project.packagist_name)"
                        method="get">
                        {{ project.namespace }}/{{ project.name }}
                    </InertiaLink>
                </td>
                <td class="p-4 text-black-lightest">
                    <div class="flex items-baseline">
                        {{ project.debt_score }}
                    </div>
                </td>
                <td class="hidden p-4 text-black-lightest md:table-cell">
                    <img
                        :src="`data:image/jpeg;base64, ${project.debt_score_graph}`"
                        :alt="`debt score graph for project ${project.namespace}/${project.name}`"
                        width="80"
                        height="20">
                </td>
                <td class="hidden p-4 text-black-lightest md:table-cell">
                    {{ project.old_pull_requests_count }}
                </td>
                <td class="hidden p-4 text-black-lightest md:table-cell">
                    {{ project.old_issues_count }}
                </td>
                <td class="hidden p-4 text-black-lightest md:table-cell">
                    {{ project.pull_requests_count }}
                </td>
                <td class="hidden p-4 text-black-lightest md:table-cell">
                    {{ project.issues_count }}
                </td>

                <td
                    v-if="hacktoberfest"
                    class="hidden p-4 md:table-cell">
                    <a
                        class="-mx-2 p-2 text-indigo-600 no-underline"
                        :href="'https://github.com/' + project.namespace + '/' + project.name + '/labels/hacktoberfest'"
                        target="_blank">
                        {{ project.hacktoberfest_issues }}
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script lang="ts">
import { PropType } from 'vue';
import { Project } from '@/ozzie';
import { ozzieProjectUrl } from '@/functions/url';

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
};
</script>
