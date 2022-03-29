<template>
    <GitHubItem
        :project="project"
        :issue="issue"
        :body="body">
        <template #github-item-type>
            Pull Request
        </template>
        <template #title-extra>
            <div class="flex flex-col mt-4 text-gray-700 dark:text-gray-400 md:flex-row md:items-center">
                <a
                    :href="baseUrl()"
                    :title="`View the conversation about pull request #${issue.number} on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center">
                    <IconConversation />
                    <span class="text-indigo-600 dark:text-indigo-400">
                        Conversation
                    </span>
                </a>
                <a
                    :href="baseUrl('commits')"
                    :title="`View the commits of pull request #${issue.number} on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center md:ml-8">
                    <IconCommit />
                    <span class="text-indigo-600 dark:text-indigo-400">
                        Commits
                    </span>
                </a>
                <a
                    :href="baseUrl('files')"
                    :title="`View the file diffs for pull request #${issue.number} on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center md:ml-8">
                    <IconFileDiff />
                    <span class="text-indigo-600 dark:text-indigo-400">
                        Files changed
                    </span>
                </a>
            </div>
        </template>
    </GitHubItem>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Project, PullRequest } from '@/ozzie';
import IconCommit from '@/components/IconCommit.vue';
import IconFileDiff from '@/components/IconFileDiff.vue';
import IconConversation from '@/components/IconConversation.vue';
import GitHubItem from '@/components/GitHubItem.vue';

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
        issue: {
            type: Object as PropType<PullRequest>,
            required: true,
        },
        body: {
            type: String,
            required: true,
        },
    },
    methods: {
        baseUrl(section?: string): string {
            return (section)
                ? `${this.issue.html_url}/${section}`
                : this.issue.html_url;
        },
    },
};
</script>
