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
import { Issue, Project } from '../../ozzie';
import GithubItem from '../../components/GithubItem.vue';

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
