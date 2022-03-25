<template>
    <div class="ml-2 flex flex-col">
        <div class="flex items-center justify-between">
            <div>
                <InertiaLink
                    class="flex-1 break-words font-medium leading-normal text-black-lighter no-underline"
                    :href="ozzieUrl"
                    method="get"
                    target="_blank"
                    preserve-state>
                    {{ gitHubItem.title }}
                </InertiaLink>
                <span
                    v-if="Object.keys(gitHubItem.labels).length > 0"
                    class="ml-2 hidden md:inline">
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
                rel="noopener noreferrer"
                @click.stop>
                <IconGitHub />
            </a>
        </div>
        <div class="text-sm text-gray-darkest">
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
                class="text-indigo-600 no-underline"
                @click.stop>
                @{{ gitHubItem.user.login }}
            </a>
        </div>
    </div>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, PullRequest } from '@/ozzie';
import IconGitHub from '@/components/IconGitHub.vue';
import GitHubLabel from '@/components/GitHubLabel.vue';

export default {
    name: 'GithubListItem',
    components: { GitHubLabel, IconGitHub },
    props: {
        projectName: {
            type: String,
            required: true,
        },
        projectNamespace: {
            type: String,
            required: true,
        },
        gitHubItem: {
            required: true,
            type: Object as PropType<Issue|PullRequest>,
        },
        ozzieUrl: {
            type: String,
            required: true,
        },
    },
};
</script>
