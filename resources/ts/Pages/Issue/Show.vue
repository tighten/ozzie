<template>
    <GitHubItem
        :project="project"
        :issue="issue">
        <template #github-item-type>
            Issue
        </template>
    </GitHubItem>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project } from '../../ozzie';
import GitHubItem from '../../components/GitHubItem.vue';

export default {
    components: {
        GitHubItem,
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
