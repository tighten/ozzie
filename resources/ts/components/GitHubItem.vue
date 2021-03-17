<!-- eslint-disable vue/no-v-html -->
<template>
    <Layout :title="'Ozzie - ' + project.namespace + '/' + project.name + ' - #' + issue.number">
        <BreadCrumb
            :project="project"
            :issue="issue" />
        <ProjectHeader
            :project="project"
            :issue="issue" />
        <DebtTable
            :show-project-name="false"
            :projects="[project]"
            class="hidden md:table" />
        <Card class="mt-4 px-2 pt-2 md:px-4 md:pt-4">
            <a
                :href="issue.html_url"
                :title="'View #' + issue.number + ' on GitHub'"
                class="no-underline"
                aria-label="Launch"
                target="_blank"
                rel="noopener noreferrer">
                <h2 class="flex flex-col md:flex-row text-2xl md:text-3xl text-indigo">
                    {{ issue.title }}<span class="ml-1 md:ml-2 text-xl md:text-3xl font-thin text-grey-dark">#{{ issue.number }}</span>
                </h2>
            </a>
            <p class="mt-1">
                <a
                    :href="`https://github.com/${issue.user.login}`"
                    :title="`View ${issue.user.login}'s profile overview on GitHub`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-indigo">
                    {{ issue.user.login }}
                </a>
                <span class="text-grey-blue-dark"> opened this issue {{ $luxon.fromISO(issue.created_at).toRelative() }}</span>
            </p>
            <slot name="title-extra" />
            <div
                class="my-4 markdown-body"
                v-html="body" />
        </Card>
    </Layout>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project, PullRequest } from '@/ozzie.ts';
import Layout from '@/Pages/Layout.vue';
import ProjectHeader from '@/components/ProjectHeader.vue';
import Card from '@/components/Card.vue';
import DebtTable from '@/components/DebtTable.vue';
import BreadCrumb from '@/components/BreadCrumb.vue';

export default {
    components: {
        BreadCrumb,
        Card,
        Layout,
        ProjectHeader,
        DebtTable,
    },
    props: {
        project: {
            type: Object as PropType<Project>,
            required: true,
        },
        issue: {
            required: true,
            type: Object as PropType<Issue|PullRequest>,
        },
        body: {
            type: String,
            required: true,
        },
    },
    data(): Record<string, unknown> {
        return {
            parsedGitHubItemBody: '',
            loaded: false,
        };
    },
};
</script>
