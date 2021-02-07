<template>
  <layout :title="'Ozzie - ' + project.namespace + '/' + project.name">
    <GoBack />
    <ProjectHeader
      :namespace="project.namespace"
      :name="project.name"
      :url="project.url"
      :maintainers="project.maintainers"
    />
    <div class="overflow-x-auto max-w-full shadow rounded">
      <table class="table-auto rounded-lg shadow w-full">
        <thead class="bg-grey-blue-light border-grey border-b-2 text-left">
          <tr>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
              Debt Score
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
              Old Prs
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
              Old Issues
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
              Prs
            </th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
              Issues
            </th>
          </tr>
        </thead>

        <tbody class="bg-white rounded-b-lg divide-y divide-smoke">
          <tr>
            <td class="text-black-lightest p-4">
              {{ project.debtScore }}
            </td>
            <td class="text-black-lightest p-4">
              {{ project.oldPrCount }}
            </td>
            <td class="text-black-lightest p-4">
              {{ project.oldIssueCount }}
            </td>
            <td class="text-black-lightest p-4">
              {{ project.pullRequestCount }}
            </td>
            <td class="text-black-lightest p-4">
              {{ project.issueCount }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

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
                  class="text-black-lighter font-medium no-underline leading-normal truncate flex-1"
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
      <card-header>Issues</card-header>
      <card-body>
        <ul class="space-y-6">
          <li
            v-for="issue in project.issues"
            :key="issue.node_id"
          >
            <github-list-item
              :git-hub-item="issue"
              :project-namespace="project.namespace"
              :project-name="project.name"
            >
              <template #link>
                <inertia-link
                  class="text-black-lighter font-medium no-underline leading-normal truncate flex-1"
                  :href="`/inertia/projects/${project.namespace}/${project.name}/issues/${issue.number}`"
                  method="get"
                  target="_blank"
                  preserve-state
                >
                  {{ issue.title }}
                </inertia-link>
              </template>
            </github-list-item>
          </li>
        </ul>
      </card-body>
    </card>
  </layout>
</template>

<script>
import Layout from '../Layout';
import GoBack from '../../components/GoBack';
import ProjectHeader from '../Partials/ProjectHeader';
import Card from '../../components/Card';
import CardHeader from '../../components/CardHeader';
import CardBody from '../../components/CardBody';
import GithubListItem from '../Partials/GithubListItem';

export default {
  components: {
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
