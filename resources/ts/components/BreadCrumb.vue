<template>
    <div class="flex mt-2">
        <InertiaLink
            class="text-indigo"
            :href="$route('projects.index')"
            method="get">
            Home
        </InertiaLink>
        <span
            v-if="project"
            class="mx-1">&gt;</span>
        <InertiaLink
            v-if="project"
            class="text-indigo"
            :href="ozzieProjectUrl(project.packagist_name)"
            method="get">
            {{ project.packagist_name }}
        </InertiaLink>
        <span
            v-if="issue"
            class="mx-1">&gt;</span>
        <span v-if="issue">#{{ issue.number }}</span>
    </div>
</template>
<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project, PullRequest } from '@/ozzie';
import { ozzieProjectUrl } from '@/functions/url';

export default {
    name: 'BreadCrumb',
    props: {
        project: {
            type: Object as PropType<Project>,
            default: null,
        },
        issue: {
            type: Object as PropType<Issue|PullRequest>,
            default: null,
        },
    },
    methods: {
        ozzieProjectUrl,
    },
};
</script>
