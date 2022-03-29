<template>
    <div class="flex flex-col justify-between mt-2 md:flex-rows md:mt-6">
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
        <p class="text-gray-600 dark:text-gray-300">
            Maintained by
            <a
                v-for="maintainer in project.maintainers"
                :key="maintainer"
                :href="`https://github.com/${maintainer}`"
                :title="`View ${maintainer}'s profile overview on GitHub`"
                target="_blank"
                rel="noopener noreferrer"
                class="text-indigo-600 no-underline dark:text-indigo-400">
                @{{ maintainer }}
            </a>
        </p>
    </div>
    <p class="font-light text-gray-700 dark:text-gray-400 md:mt-1">
        Synced {{ $luxon.fromISO(project.updated_at).toRelative() }}
    </p>
    <p
        v-if="project.has_downloads"
        class="font-light text-gray-700 dark:text-gray-400">
        {{ new Intl.NumberFormat().format(project.downloads_total) }} downloads
        ({{ new Intl.NumberFormat().format(project.downloads_last_30_days) }} per month)
    </p>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project, PullRequest } from '@/ozzie';
import IconGitHub from '@/components/IconGitHub.vue';

export default {
    name: 'ProjectHeader',
    components: {
        IconGitHub,
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
