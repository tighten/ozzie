<template>
    <GitHubItem
        :project="project"
        :issue="issue"
        :body="body">
        <template #github-item-type>
            Pull Request
        </template>
        <template #title-extra>
            <div class="mt-4 flex flex-col md:flex-row md:items-center text-black-lighter">
                <a
                    :href="baseUrl()"
                    :title="`View the conversation about pull request #${issue.number} on GitHub`"
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
                    :title="`View the commits of pull request #${issue.number} on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="md:ml-8 flex items-center">
                    <IconCommit />
                    <span class="text-indigo">
                        Commits
                    </span>
                </a>
                <a
                    :href="baseUrl('files')"
                    :title="`View the file diffs for pull request #${issue.number} on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="md:ml-8 flex items-center">
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
import { Project, PullRequest } from '@/ozzie.ts';
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
