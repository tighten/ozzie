<template>
    <div class="flex flex-col justify-between mt-2 md:flex-rows md:mt-6">
        <h1 class="text-2xl tracking-wide text-black-lightest">
            <a
                :href="`https://github.com/${project.namespace}/${project.name}`"
                :title="`View project ${project.namespace }/${ project.name } on GitHub`"
                target="_blank"
                class="hover:text-black"
                rel="noopener noreferrer">
                {{ project.namespace }}/{{ project.name }}<IconGitHub class="ml-1" />
            </a>
            <span
                v-show="project.is_hidden"
                class="inline-flex items-center ml-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-grey-blue text-black">
                Hidden
            </span>
        </h1>
        <p class="text-black-lightest">
            Maintained by
            <a
                v-for="maintainer in project.maintainers"
                :key="maintainer"
                :href="`https://github.com/${maintainer}`"
                :title="`View ${maintainer}'s profile overview on GitHub`"
                target="_blank"
                rel="noopener noreferrer"
                class="no-underline text-indigo">
                @{{ maintainer }}
            </a>
        </p>
    </div>
    <p class="font-light text-grey-dark md:mt-1">
        Synced {{ $luxon.fromISO(project.updated_at).toRelative() }}
    </p>
    <p
        v-if="project.has_downloads"
        class="font-light text-grey-dark">
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
