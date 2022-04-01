<template>
    <div class="flex items-center justify-between mt-8">
        <h1 class="text-2xl tracking-wide text-gray-900 dark:text-gray-200">
            <a
                :href="`https://github.com/${project.namespace}/${project.name}`"
                :title="`View project ${project.namespace }/${ project.name } on GitHub`"
                target="_blank"
                class="flex space-x-2 hover:text-indigo-600 group dark:hover:text-indigo-400"
                rel="noopener noreferrer">
                <span>{{ project.namespace }}/{{ project.name }}</span>
                <IconGitHub class="flex items-center" />
            </a>
        </h1>
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-1 text-sm text-gray-600 dark:text-gray-300">
                <UsersIcon title="Maintained by" class="w-6 h-6 text-gray-400" />
                <div class="relative flex -space-x-1">
                    <a
                        v-for="maintainer in project.maintainers"
                        :key="maintainer"
                        :href="`https://github.com/${maintainer}`"
                        :title="`View ${maintainer}'s profile overview on GitHub`"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-indigo-600 no-underline dark:text-indigo-400"
                    >
                        <img :src="`https://github.com/${maintainer}.png`" :alt="maintainer" class="w-6 h-6 rounded-full ring-2 ring-gray-100 dark:ring-gray-900">
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-1 text-sm font-light text-gray-500 dark:text-gray-400">
                <RefreshIcon class="w-6 h-6 text-gray-400 -scale-x-100" />
                <span :title="'Synced ' + $luxon.fromISO(project.updated_at).toRelative()">{{ $luxon.fromISO(project.updated_at).toRelative() }}</span>
            </div>
            <div class="flex items-center space-x-1 text-sm font-light text-gray-500 dark:text-gray-400">
                <DownloadIcon class="w-6 h-6 text-gray-400" />
                <span :title="new Intl.NumberFormat().format(project.downloads_total) + ' total downloads'">{{ new Intl.NumberFormat().format(project.downloads_total) }}</span>
            </div>
            <div class="flex items-center space-x-1 text-sm font-light text-gray-500 dark:text-gray-400">
                <CalendarIcon class="w-6 h-6 text-gray-400" />
                <span :title="new Intl.NumberFormat().format(project.downloads_last_30_days)  + ' downloads per month'">{{ new Intl.NumberFormat().format(project.downloads_last_30_days) }}</span>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project, PullRequest } from '@/ozzie';
import { CalendarIcon, DownloadIcon, RefreshIcon, UsersIcon } from '@heroicons/vue/outline'
import IconGitHub from '@/components/IconGitHub.vue';

export default {
    name: 'ProjectHeader',
    components: {
        IconGitHub,
        CalendarIcon,
        DownloadIcon,
        RefreshIcon,
        UsersIcon,
    },
    props: {
        project: {
            type: Object as PropType<Project>,
            required: true,
        },
        issue: {
            type: Object as PropType<Issue|PullRequest>,
            default: null,
        },
    },
};
</script>
