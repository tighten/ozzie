<template>
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center px-3 pt-3 pb-2 space-x-2 bg-white shadow dark:border dark:border-gray-700 dark:border-t-0 dark:bg-gray-800 rounded-b-md">
            <li>
                <div>
                    <InertiaLink
                        :href="$route('projects.index')"
                        class="text-gray-500 dark:text-gray-400 dark:hover:text-indigo-400 hover:text-indigo-600"
                    >
                        <HomeIcon
                            class="flex-shrink-0 w-5 h-5"
                            aria-hidden="true"
                        />
                        <span class="sr-only">Home</span>
                    </InertiaLink>
                </div>
            </li>
            <li v-if="project">
                <div class="flex items-center">
                    <ChevronRightIcon
                        class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500"
                        aria-hidden="true"
                    />
                    <InertiaLink
                        :href="ozzieProjectUrl(project.packagist_name)"
                        class="ml-2 text-sm font-medium text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400"
                    >
                        {{ project.packagist_name }}
                    </InertiaLink>
                </div>
            </li>
            <li v-if="issue">
                <div class="flex items-center">
                    <ChevronRightIcon
                        class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500"
                        aria-hidden="true"
                    />
                    <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                        #{{ issue.number }}
                    </span>
                </div>
            </li>
        </ol>
    </nav>
</template>
<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project, PullRequest } from '@/ozzie';
import { ozzieProjectUrl } from '@/functions/url';
import { ChevronRightIcon, HomeIcon } from '@heroicons/vue/solid';

export default {
    name: 'BreadCrumb',
    components: {
        ChevronRightIcon,
        HomeIcon,
    },
    props: {
        project: {
            type: Object as PropType<Project>,
            default: null,
        },
        issue: {
            type: Object as PropType<Issue | PullRequest>,
            default: null,
        },
    },
    methods: {
        ozzieProjectUrl,
    },
};
</script>
