<template>
    <div class="mt-2 md:mt-6 flex flex-col md:flex-rows justify-between">
        <h1 class="text-2xl text-black-lightest tracking-wide">
            <a
                :href="`https://github.com/${project.namespace}/${project.name}`"
                :title="`View project ${project.namespace }/${ project.name } on GitHub`"
                target="_blank"
                rel="noopener noreferrer">
                {{ project.namespace }}/{{ project.name }}<IconGitHub class="ml-1" />
            </a>
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
                class="text-indigo no-underline">
                @{{ maintainer }}
            </a>
        </p>
    </div>
    <p class="md:mt-1 text-grey-dark font-light">
        Synced {{ $luxon.fromISO(project.updated_at).toRelative() }}
    </p>
    <p
        v-if="project.has_downloads"
        class="text-grey-dark font-light">
        {{ new Intl.NumberFormat().format(project.downloads_total) }} downloads
        ({{ new Intl.NumberFormat().format(project.downloads_last_30_days) }}  per month)
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
