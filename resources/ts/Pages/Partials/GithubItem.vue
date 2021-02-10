<template>
    <Layout :title="'Ozzie - ' + project.namespace + '/' + project.name + ' - #' + issue.number">
        <GoBack />
        <ProjectHeader :project="project" />
        <Card>
            <CardHeader>
                <div class="flex justify-between">
                    <!-- ITEM TYPE -->
                    <slot name="github-item-type" />
                    <span class="normal-case font-normal">opened by <a
                        class="font-semibold text-indigo"
                        :href="issue.user.login"
                        target="_blank"
                    >
                        {{ issue.user.login }}
                    </a> {{ $luxon.fromISO(issue.created_at).toRelative() }}
                    </span>
                </div>
            </CardHeader>
            <CardBody>
                <h2 class="mt-0 text-xl text-black font-semibold tracking-wide leading-none truncate">
                    {{ issue.title }}
                    <span class="ml-2 text-grey-dark font-normal">
                        #{{ issue.number }}
                    </span>
                </h2>

                <!-- TITLE EXTRA -->
                <slot name="title-extra" />

                <div
                    v-if="loaded"
                    class="mt-4 markdown-body"
                >
                    <div
                        v-if="issue.body !== ''"
                        class="pt-4 border-t border-clouds"
                    >
                        <article v-html="parsedGithubItemBody" />
                    </div>
                    <em
                        v-else
                        class="text-grey-darker"
                    >No description provided.</em>
                </div>
            </CardBody>
        </Card>
    </Layout>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Issue, Project, PullRequest } from '../../ozzie.d.ts';
import Layout from '../Layout';
import GoBack from '../../components/GoBack';
import ProjectHeader from './ProjectHeader';
import Card from '../../components/Card';
import CardBody from '../../components/CardBody';
import CardHeader from '../../components/CardHeader';

export default {
    components: {
        CardHeader,
        CardBody,
        Card,
        GoBack,
        Layout,
        ProjectHeader,
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
