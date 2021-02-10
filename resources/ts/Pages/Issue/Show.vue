<template>
    <GithubItem
        :project="project"
        :issue="issue"
    >
        <template #github-item-type>
            Issue
        </template>
    </GithubItem>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project } from '../../ozzie.d.ts';
import GithubItem from '../Partials/GithubItem';

export default {
    components: {
        GithubItem,
    },
    props: {
        project: {
            type: Object as PropType<Project>,
            required: true,
        },
        issue: {
            type: Object as PropType<Issue>,
            required: true,
        },
    },
};
</script>
