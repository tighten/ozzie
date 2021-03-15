<template>
    <Layout :title="'Ozzie - ' + project.namespace + '/' + project.name">
        <BreadCrumb :project="project" />
        <ProjectHeader :project="project" />
        <DebtTable
            :show-project-name="false"
            :projects="[project]"
            class="hidden mt-4 md:table" />
        <Card
            v-if="project.pull_requests_count > 0"
            class="mt-4 md:mt-8">
            <CardHeader>{{ project.pull_requests_count }} open Pull Requests</CardHeader>
            <ul class="divide-y divide-grey-blue">
                <li
                    v-for="pull_request in project.pull_requests"
                    :key="pull_request.node_id">
                    <GitHubListItem
                        :git-hub-item="pull_request"
                        :project-namespace="project.namespace"
                        :project-name="project.name"
                        :ozzie-url="ozzieUrl(project.packagist_name, 'pull-request', pull_request.number)" />
                </li>
            </ul>
        </Card>
        <Card
            v-if="project.issues_count > 0"
            class="mt-4 md:mt-8">
            <CardHeader>{{ project.issues_count }} open Issues </CardHeader>
            <ul class="divide-y divide-grey-blue">
                <li
                    v-for="issue in project.issues"
                    :key="issue.node_id">
                    <GitHubListItem
                        :git-hub-item="issue"
                        :project-namespace="project.namespace"
                        :project-name="project.name"
                        :ozzie-url="ozzieUrl(project.packagist_name, 'issue', issue.number)" />
                </li>
            </ul>
        </Card>
    </Layout>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Project } from '@/ozzie.ts';
import Layout from '@/Pages/Layout.vue';
import ProjectHeader from '@/components/ProjectHeader.vue';
import Card from '@/components/Card.vue';
import CardHeader from '@/components/CardHeader.vue';
import GitHubListItem from '@/components/GitHubListItem.vue';
import DebtTable from '@/components/DebtTable.vue';
import BreadCrumb from '@/components/BreadCrumb.vue';

export default {
    components: {
        BreadCrumb,
        DebtTable,
        GitHubListItem,
        CardHeader,
        Card,
        ProjectHeader,
        Layout,
    },
    props: {
        project: {
            type: Object as PropType<Project>,
            required: true,
        },
    },
    methods: {
        ozzieUrl(packageName: string, type: string, id: number): string {
            const [vendor, name] = packageName.split('/');
            return this.$route(`${type}.show`, { vendor, name, id });
        },
    },
};
</script>
