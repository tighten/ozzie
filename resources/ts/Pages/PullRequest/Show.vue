<template>
    <GitHubItem
        :project="project"
        :issue="pullRequest">
        <template #github-item-type>
            Pull Request
        </template>
        <template #title-extra>
            <div class="mt-4 flex items-center text-black-lighter">
                <a
                    :href="baseUrl()"
                    :title="`View the conversation about pull request #${pullRequest.number} on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center">
                    <IconConversation />
                    <span class="text-indigo">
                        Conversation
                    </span>
                </a>
                <a
                    :href="baseUrl('commits')"
                    :title="`View the commits of pull request #${pullRequest.number} on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="ml-8 flex items-center">
                    <IconCommit />
                    <span class="text-indigo">
                        Commits
                    </span>
                </a>
                <a
                    :href="baseUrl('files')"
                    :title="`View the file diffs for pull request #${pullRequest.number} on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="ml-8 flex items-center">
                    <IconFileDiff />
                    <span class="text-indigo">
                        Files changed
                    </span>
                </a>
            </div>
        </template>
    </GitHubItem>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Project, PullRequest } from '../../ozzie';
import IconCommit from '../../components/IconCommit.vue';
import IconFileDiff from '../../components/IconFileDiff.vue';
import IconConversation from '../../components/IconConversation.vue';
import GitHubItem from '../../components/GitHubItem.vue';

export default {
    components: {
        GitHubItem,
        IconConversation,
        IconCommit,
        IconFileDiff,
    },
    props: {
        project: {
            type: Object as PropType<Project>,
            required: true,
        },
        pullRequest: {
            type: Object as PropType<PullRequest>,
            required: true,
        },
    },
    methods: {
        baseUrl(section?: string) {
            return (section)
                ? `${this.pullRequest.html_url}/${section}`
                : this.pullRequest.html_url;
        },
    },
};
</script>
