<template>
    <Layout :title="'Ozzie - ' + project.namespace + '/' + project.name + ' - #' + issue.number">
        <BreadCrumb
            :project="project"
            :issue="issue"
        />
        <ProjectHeader
            :project="project"
            :issue="issue"
        />
        <DebtTable
            :show-project-name="false"
            :projects="[project]"
            class="mt-4"
        />
        <Card class="mt-4 px-4 pt-4">
            <h2 class="text-3xl">
                {{ issue.title }}<span class="ml-2 font-thin text-grey-dark">#{{ issue.number }}</span>
            </h2>
            <p class="mt-1">
                <a
                    class="font-semibold text-grey-blue-darkest"
                    :href="issue.user.login"
                    target="_blank"
                >
                    {{ issue.user.login }}
                </a>
                <span class="text-grey-blue-dark"> opened this issue {{ $luxon.fromISO(issue.created_at).toRelative() }}</span>
            </p>
            <!-- TITLE EXTRA -->
            <slot name="title-extra" />
            <div
                v-if="loaded"
                class="mt-4 markdown-body"
            >
                <article
                    v-if="issue.body !== ''"
                    v-html="parsedGithubItemBody"
                />
                <div
                    v-else
                    class="pb-4 text-grey-darker"
                >
                    <em>
                        No description provided.
                    </em>
                </div>
            </div>
        </Card>
    </Layout>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project, PullRequest } from '../../ozzie';
import Layout from '../Layout';
import ProjectHeader from './ProjectHeader';
import Card from '../../components/Card';
import DebtTable from '../../components/DebtTable/DebtTable.vue';
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
    },
    data() {
        return {
            parsedGithubItemBody: '',
            loaded: false,
        };
    },
    mounted() {
        const options = { headers: { Authorization: `token ${window.githubToken}` } };
        const data = { text: this.issue.body };
        this.$http.post('https://api.github.com/markdown', data, options).then(
            (response) => {
                this.parsedGithubItemBody = response.data;
                this.loaded = true;
            },
        );
    },
};
</script>
