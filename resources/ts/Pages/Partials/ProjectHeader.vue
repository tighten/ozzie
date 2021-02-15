<template>
    <div class="flex items-center mt-2">
        <InertiaLink
            class="text-indigo"
            :href="$route('projects.index')"
            method="get"
        >
            Home
        </InertiaLink>
        <span class="mx-1">&gt;</span>
        <InertiaLink
            class="text-indigo"
            :href="$route('projects.show', {
                namespace: project.namespace,
                name: project.name,
            })"
            method="get"
        >
            {{ project.namespace }}/{{ project.name }}
        </InertiaLink>
        <span
            v-if="issue"
            class="mx-1"
        >
            <span>&gt; #{{ issue.number }}</span>
        </span>
    </div>
    <div class="mt-6 flex justify-between items-center">
        <h1 class="text-2xl text-black-lightest tracking-wide">
            {{ project.namespace }}/{{ project.name }}
        </h1>
        <p class="text-black-lightest">
            Maintained by
            <a
                v-for="maintainer in project.maintainers"
                :key="maintainer"
                class="text-indigo no-underline"
                :href="`https://github.com/${maintainer}`"
                target="_blank"
            >
                @{{ maintainer }}
            </a>
        </p>
    </div>
    <p class="mt-1 text-grey-dark font-light">
        Synced {{ $luxon.fromISO(project.updated_at).toRelative() }}
    </p>
    <p
        v-if="project.hasDownloads"
        class="text-grey-dark font-light"
    >
        {{ new Intl.NumberFormat().format(project.downloads_total) }} downloads ({{ new Intl.NumberFormat().format(project.downloads_last_30_days) }}  per month)
    </p>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Project, Issue, PullRequest } from '../../ozzie.ts';

export default {
    name: 'ProjectHeader',
    components: {
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
