<template>
  <Layout :title="'Ozzie - ' + project.namespace + '/' + project.name">
    <GoBack />
    <ProjectHeader
      :namespace="project.namespace"
      :name="project.name"
      :url="project.url"
      :maintainers="project.maintainers"
    />
    <DebtTable
      :show-project-name="false"
      :projects="[project]"
    />
    <Card
      v-if="project.pullRequestCount > 0"
      class="mt-8"
    >
      <CardHeader>Pull Requests</CardHeader>
      <CardBody>
        <ul class="space-y-6">
          <li
            v-for="pr in project.prs"
            :key="pr.node_id"
          >
            <GithubListItem
              :git-hub-item="pr"
              :project-namespace="project.namespace"
              :project-name="project.name"
            >
              <template #link>
                <InertiaLink
                  class="flex-1 font-medium leading-normal no-underline text-black-lighter truncate"
                  :href="`/inertia/projects/${project.namespace}/${project.name}/prs/${pr.number}`"
                  method="get"
                  target="_blank"
                  preserve-state
                >
                  {{ pr.title }}
                </InertiaLink>
              </template>
            </GithubListItem>
          </li>
        </ul>
      </CardBody>
    </Card>
    <Card
      v-if="project.issueCount > 0"
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

<script>
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
      type: Object,
      required: true,
    },
  },
};
</script>
