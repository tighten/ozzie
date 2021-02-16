<template>
    <GithubItem
        :project="project"
        :issue="pullRequest"
    >
        <template #github-item-type>
            Pull Request
        </template>
        <template #title-extra>
            <div class="mt-4 flex items-center text-black-lighter">
                <a
                    class="flex items-center"
                    :href="baseUrl()"
                    target="_blank"
                >
                    <IconConversation />
                    <span class="text-indigo">
                        Conversation
                    </span>
                </a>
                <a
                    class="ml-8 flex items-center"
                    :href="baseUrl('commits')"
                    target="_blank"
                >
                    <IconCommit />
                    <span class="text-indigo">
                        Commits
                    </span>
                </a>
                <a
                    class="ml-8 flex items-center"
                    :href="baseUrl('files')"
                    target="_blank"
                >
                    <IconFileDiff />
                    <span class="text-indigo">
                        Files changed
                    </span>
                </a>
            </div>
        </template>
    </GithubItem>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Project, PullRequest } from '../../ozzie';
import GithubItem from '../../components/GithubItem.vue';
import IconCommit from '../../components/IconCommit.vue';
import IconFileDiff from '../../components/IconFileDiff.vue';
import IconConversation from '../../components/IconConversation.vue';

export default {
    components: {
        IconConversation,
        IconCommit,
        IconFileDiff,
        GithubItem,
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
