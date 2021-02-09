<template>
  <Layout :title="'Ozzie - ' + project.namespace + '/' + project.name">
    <GoBack />
    <ProjectHeader
      :namespace="project.namespace"
      :name="project.name"
      :url="project.url"
      :maintainers="project.maintainers"
    />
    <div class="overflow-x-auto max-w-full rounded">
      <table class="w-full text-xs font-medium tracking-wide leading-none rounded-lg table-auto text-grey-darkest">
        <thead class="text-left uppercase border-b-2 bg-grey-blue-light border-grey">
          <tr>
            <th class="p-4">
              Debt Score
            </th>
            <th class="p-4">
              Old Prs
            </th>
            <th class="p-4">
              Old Issues
            </th>
            <th class="p-4">
              Prs
            </th>
            <th class="p-4">
              Issues
            </th>
          </tr>
        </thead>

        <tbody class="bg-white rounded-b-lg divide-y divide-smoke">
          <tr>
            <td class="p-4 text-black-lightest">
              {{ project.debtScore }}
            </td>
            <td class="p-4 text-black-lightest">
              {{ project.oldPrCount }}
            </td>
            <td class="p-4 text-black-lightest">
              {{ project.oldIssueCount }}
            </td>
            <td class="p-4 text-black-lightest">
              {{ project.pullRequestCount }}
            </td>
            <td class="p-4 text-black-lightest">
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
