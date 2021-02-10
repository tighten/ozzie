<template>
    <Layout :title="'Ozzie - ' + project.namespace + '/' + project.name">
        <GoBack />
        <ProjectHeader :project="project" />
        <DebtTable
            :show-project-name="false"
            :projects="[project]"
        />
        <Card
            v-if="project.pull_requests_count > 0"
            class="mt-8"
        >
            <CardHeader>Pull Requests</CardHeader>
            <CardBody>
                <ul class="space-y-6">
                    <li
                        v-for="pull_request in project.pull_requests"
                        :key="pull_request.node_id"
                    >
                        <GithubListItem
                            :git-hub-item="pull_request"
                            :project-namespace="project.namespace"
                            :project-name="project.name"
                        >
                            <template #link>
                                <InertiaLink
                                    class="flex-1 font-medium leading-normal no-underline text-black-lighter truncate"
                                    :href="`/inertia/projects/${project.namespace}/${project.name}/prs/${pull_request.number}`"
                                    method="get"
                                    target="_blank"
                                    preserve-state
                                >
                                    {{ pull_request.title }}
                                </InertiaLink>
                            </template>
                        </GithubListItem>
                    </li>
                </ul>
            </CardBody>
        </Card>
        <Card
            v-if="project.issues_count > 0"
            class="mt-8"
        >
            <CardHeader>Issues</CardHeader>
            <CardBody>
                <ul class="space-y-6">
                    <li
                        v-for="issue in project.issues"
                        :key="issue.node_id"
                    >
                        <GithubListItem
                            :git-hub-item="issue"
                            :project-namespace="project.namespace"
                            :project-name="project.name"
                        >
                            <template #link>
                                <InertiaLink
                                    class="flex-1 font-medium leading-normal no-underline text-black-lighter truncate"
                                    :href="`/inertia/projects/${project.namespace}/${project.name}/issues/${issue.number}`"
                                    method="get"
                                    target="_blank"
                                    preserve-state
                                >
                                    {{ issue.title }}
                                </InertiaLink>
                            </template>
                        </GithubListItem>
                    </li>
                </ul>
            </CardBody>
        </Card>
    </Layout>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Project } from '../../ozzie.ts';
import Layout from '../Layout';
import GoBack from '../../components/GoBack';
import ProjectHeader from '../Partials/ProjectHeader';
import Card from '../../components/Card';
import CardHeader from '../../components/CardHeader';
import CardBody from '../../components/CardBody';
import GithubListItem from '../Partials/GithubListItem';
import DebtTable from '../../components/DebtTable/DebtTable';

export default {
    components: {
        DebtTable,
        GithubListItem,
        CardBody,
        CardHeader,
        Card,
        ProjectHeader,
        GoBack,
        Layout,
    },
    props: {
        project: {
            type: Object as PropType<Project>,
            required: true,
        },
    },
};
</script>
