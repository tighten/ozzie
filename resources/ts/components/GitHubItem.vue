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
            :projects="[project]" />
        <Card class="mt-4 px-4 pt-4">
            <h2 class="text-3xl">
                {{ issue.title }}<span class="ml-2 font-thin text-grey-dark">#{{ issue.number }}</span>
            </h2>
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
            <!-- TITLE EXTRA -->
            <slot name="title-extra" />
            <div
                class="my-4 markdown-body"
                v-html="body" />
        </Card>
    </Layout>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project, PullRequest } from '../ozzie';
import Layout from '../Pages/Layout.vue';
import ProjectHeader from './ProjectHeader.vue';
import Card from './Card.vue';
import DebtTable from './DebtTable.vue';
import BreadCrumb from './BreadCrumb.vue';

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
    data() {
        return {
            parsedGitHubItemBody: '',
            loaded: false,
        };
    },
};
</script>
