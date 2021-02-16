<template>
    <CardRow>
        <div class="flex items-start">
            <a
                class="no-underline"
                :href="gitHubItem.html_url"
                target="_blank"
                aria-label="Launch"
                :title="'open issue #' + gitHubItem.number + ' on github'"
            >
                <IconGitHub />
            </a>
            <div class="ml-2 flex flex-col">
                <div class="flex items-center">
                    <InertiaLink
                        class="flex-1 font-medium leading-normal no-underline text-black-lighter truncate"
                        :href="ozzieUrl"
                        method="get"
                        target="_blank"
                        preserve-state
                    >
                        {{ gitHubItem.title }}
                    </InertiaLink>
                    <span
                        v-if="Object.keys(gitHubItem.labels).length > 0"
                        class="ml-2"
                    >
                        <a
                            v-for="label in gitHubItem.labels"
                            :key="label.name"
                            class="mr-1 mt-2 inline-flex items-center py-1 pl-1 pr-2 hover:bg-grey-blue-light font-sans font-semibold no-underline leading-none text-xs capitalize rounded-full"
                            :href="'https://github.com/' + projectNamespace + '/' + projectName + '/labels/' + label.name"
                            target="_blank"
                            :style="`background-color: #${label.color};`"
                        >
                            <span
                                class="ml-1"
                                :style="'color: ' + getCorrectTextColor('#' + label.color)"
                            >{{ label.name }}</span>
                        </a>
                    </span>
                </div>
                <div class="text-grey-darkest text-sm">
                    #{{ gitHubItem.number }}
                    opened
                    <span>
                        {{ $luxon.fromISO(gitHubItem.created_at).toRelative() }}
                    </span>
                    by
                    <a
                        class="text-indigo no-underline"
                        :href="gitHubItem.user.html_url"
                        target="_blank"
                    >
                        @{{ gitHubItem.user.login }}
                    </a>
                </div>
            </div>
        </div>
    </CardRow>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, PullRequest } from '../ozzie.ts';
import IconGitHub from './IconGitHub.vue';
import CardRow from './CardRow.vue';

export default {
    name: 'GithubListItem',
    components: { CardRow, IconGitHub },
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
    methods: {
        // REFACTOR : Extract this method to a mixin
        getCorrectTextColor(hex): string {
            function cutHex(h) { return (h.charAt(0) === '#') ? h.substring(1, 7) : h; }
            function hexToR(h) { return parseInt((cutHex(h)).substring(0, 2), 16); }
            function hexToG(h) { return parseInt((cutHex(h)).substring(2, 4), 16); }
            function hexToB(h) { return parseInt((cutHex(h)).substring(4, 6), 16); }

            /* about half of 256. Lower threshold equals more dark text on dark background  */
            const threshold = 120;

            const hRed = hexToR(hex);
            const hGreen = hexToG(hex);
            const hBlue = hexToB(hex);

            const cBrightness = ((hRed * 299) + (hGreen * 587) + (hBlue * 114)) / 1000;
            if (cBrightness > threshold) {
                return '#000000';
            }
            return '#ffffff';
        },

    },
};
</script>
