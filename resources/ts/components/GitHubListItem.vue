<template>
    <CardRow>
        <div class="ml-2 flex flex-col">
            <div class="flex items-center justify-between">
                <div>
                    <InertiaLink
                        class="flex-1 font-medium leading-normal no-underline text-black-lighter break-words"
                        :href="ozzieUrl"
                        method="get"
                        target="_blank"
                        preserve-state>
                        {{ gitHubItem.title }}
                    </InertiaLink>
                    <span
                        v-if="Object.keys(gitHubItem.labels).length > 0"
                        class="hidden md:inline ml-2">
                        <GitHubLabel
                            v-for="label in gitHubItem.labels"
                            :key="label.name"
                            :label="label"
                            :namespace="projectNamespace"
                            :name="projectName" />
                    </span>
                </div>
                <a
                    :href="gitHubItem.html_url"
                    :title="'View #' + gitHubItem.number + ' on GitHub'"
                    class="no-underline"
                    aria-label="Launch"
                    target="_blank"
                    rel="noopener noreferrer">
                    <IconGitHub />
                </a>
            </div>
            <div class="text-grey-darkest text-sm">
                #{{ gitHubItem.number }}
                opened
                <span>
                    {{ $luxon.fromISO(gitHubItem.created_at).toRelative() }}
                </span>
                by
                <a
                    :href="gitHubItem.user.html_url"
                    :title="`View ${gitHubItem.user.login}'s profile overview on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-indigo no-underline">
                    @{{ gitHubItem.user.login }}
                </a>
            </div>
        </div>
    </CardRow>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, PullRequest } from '@/ozzie.ts';
import IconGitHub from '@/components/IconGitHub.vue';
import CardRow from '@/components/CardRow.vue';
import GitHubLabel from '@/components/GitHubLabel.vue';

export default {
    name: 'GithubListItem',
    components: { GitHubLabel, CardRow, IconGitHub },
    props: {
        projectName: {
            required: true,
            type: String,
        },
        projectNamespace: {
            required: true,
            type: String,
        },
        gitHubItem: {
            type: Object as PropType<Issue|PullRequest>,
            required: true,
        },
        ozzieUrl: {
            required: true,
            type: String,
        },
    },
};
</script>
