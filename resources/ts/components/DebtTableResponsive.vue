<template>
    <!-- -->
    <table class="block mt-6 w-full md:table md:table-auto">
        <thead class="block absolute text-left border-b-2 md:relative md:table-row-group md:top-0 md:left-0 top-hidden left-hidden bg-grey-blue-light border-grey">
            <tr class="block md:table-row">
                <th
                    v-if="showProjectName"
                    class="block p-4 text-xs font-bold tracking-wide leading-none uppercase md:table-cell text-grey-darkest">
                    Project Name
                </th>
                <th class="block p-4 text-xs font-bold tracking-wide leading-none uppercase md:table-cell text-grey-darkest">
                    Debt Score
                </th>
                <th class="block p-4 text-xs font-bold tracking-wide leading-none uppercase md:table-cell text-grey-darkest">
                    Debt Score Graph
                </th>
                <th class="block p-4 text-xs font-bold tracking-wide leading-none uppercase md:table-cell text-grey-darkest">
                    Old Prs
                </th>
                <th class="block p-4 text-xs font-bold tracking-wide leading-none uppercase md:table-cell text-grey-darkest">
                    Old Issues
                </th>
                <th class="block p-4 text-xs font-bold tracking-wide leading-none uppercase md:table-cell text-grey-darkest">
                    Prs
                </th>
                <th class="block p-4 text-xs font-bold tracking-wide leading-none uppercase md:table-cell text-grey-darkest">
                    Issues
                </th>
                <th
                    v-if="hacktoberfest"
                    class="block p-4 text-xs md:table-cell">
                    🎃
                </th>
            </tr>
        </thead>
        <tbody class="block divide-y bg-frost divide-smoke md:table-row-group">
            <tr
                v-for="project in projects"
                :key="project.id"
                class="block mt-4 bg-white border divide-y md:table-row border-grey divide-smoke">
                <td
                    v-if="showProjectName"
                    class="flex p-4 md:table-cell">
                    <InertiaLink
                        class="font-semibold no-underline text-indigo"
                        :href="$route('projects.show', {
                            namespace: project.namespace,
                            name: project.name,
                        })"
                        method="get">
                        {{ project.namespace }}/{{ project.name }}
                    </InertiaLink>
                </td>
                <td class="flex p-4 md:table-cell">
                    <span class="w-1/2 md:hidden">Debt score</span>
                    <div class="flex items-baseline">
                        <span
                            :class="debtScoreClass(project.debt_score)"
                            class="inline-block hidden mr-1 w-3 h-3 rounded-full" />
                        {{ project.debt_score }}
                    </div>
                </td>
                <td class="hidden p-4 text-black-lightest">
                    <img
                        :src="`data:image/jpeg;base64, ${project.debt_score_graph}`"
                        :alt="`debt score graph for project ${project.namespace}/${project.name}`"
                        width="80"
                        height="20">
                </td>
                <td class="flex p-4 md:table-cell">
                    <span class="w-1/2 md:hidden">Old Pull Requests</span>
                    {{ project.old_pull_requests_count }}
                </td>
                <td class="flex p-4 md:table-cell">
                    <span class="w-1/2 md:hidden">Old Issues</span>
                    {{ project.old_issues_count }}
                </td>
                <td class="flex p-4 md:table-cell">
                    <span class="w-1/2 md:hidden">Pull Requests</span>
                    {{ project.pull_requests_count }}
                </td>
                <td class="flex p-4 md:table-cell">
                    <span class="w-1/2 md:hidden">Issues</span>
                    {{ project.issues_count }}
                </td>
                <td
                    v-if="true"
                    class="flex p-4 md:table-cell">
                    <span class="w-1/2 md:hidden">Hacktoberfest<br>Issues</span>
                    <a
                        class="no-underline text-indigo"
                        :href="'https://github.com/' + project.namespace + '/' +project.name + '/labels/hacktoberfest'"
                        target="_blank">
                        {{ project.hacktoberfestIssues }}
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script lang="ts">
import { PropType } from 'vue';
import { Project } from '@/ozzie.ts';

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
    methods: {
        debtScoreClass(debtScore: number) {
            if (debtScore > 5) {
                return 'bg-red';
            }
            if (debtScore > 1) {
                return 'bg-orange';
            }
            return '';
        },
    },
};
</script>
