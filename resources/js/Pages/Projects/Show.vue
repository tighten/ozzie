<template>
  <layout :title="'Ozzie - ' + project.namespace + '/' + project.name">
    <GoBack />
    <ProjectHeader
      :namespace="project.namespace"
      :name="project.name"
      :url="project.url"
      :maintainers="project.maintainers"
    />
    <div class="overflow-x-auto max-w-full">
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
              {{ project.prCount }}
            </td>
            <td class="text-black-lightest p-4">
              {{ project.issueCount }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <section
      v-if="Object.keys(project.prs).length > 0"
      class="mt-8 flex flex-col bg-white rounded shadow"
    >
      <h2 class="border-grey border-b-2 p-4 bg-grey-blue-light uppercase text-xs leading-none tracking-wide font-bold text-grey-darkest">
        Pull Requests
      </h2>
      <ul class="px-6 pb-6">
        <li
          v-for="pr in project.prs"
          :key="pr.node_id"
          class="mt-6"
        >
          <div class="flex flex-col w-auto">
            <div class="flex items-baseline justify-between">
              <inertia-link
                class="text-black-lighter font-medium no-underline leading-normal truncate flex-1"
                href="/pr"
                method="post"
                target="_blank"
                preserve-state
                :data="{ project: project, pr: pr }"
              >
                {{ pr.title }}
              </inertia-link>
              <a
                class="no-underline"
                :href="pr.html_url"
                target="_blank"
                aria-label="Launch"
              >
                <IconLaunch />
              </a>
            </div>
            <div>
              <a
                class="text-indigo no-underline"
                :href="pr.user.html_url"
                target="_blank"
              >
                @{{ pr.user.login }}
              </a>
              |
              <span class="font-semibold text-grey-darkest">
                {{ $luxon.fromISO(pr.created_at).toRelative() }}
              </span>
              <div v-if="Object.keys(pr.labels).length > 0">
                <a
                  v-for="label in pr.labels"
                  :key="label.name"
                  class="mr-2 mt-1 inline-flex items-center px-2 py-1 bg-grey-blue hover:bg-grey-blue-light text-grey-blue-darkest font-sans font-semibold no-underline leading-none text-xs capitalize rounded-lg"
                  :href="'https://github.com/' + project.namespace + '/' + project.name + '/labels/' + label.name"
                  target="_blank"
                >
                  <span
                    class="rounded-full w-3 h-3"
                    :style="'background-color: #' + label.color"
                  />
                  <span class="ml-1">
                    {{ label.name }}
                  </span>
                </a>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </section>
    <section
      v-if="Object.keys(project.issues).length > 0"
      class="mt-8 flex flex-col bg-white rounded shadow"
    >
      <h2 class="border-grey border-b-2 p-4 bg-grey-blue-light uppercase text-xs leading-none tracking-wide font-bold text-grey-darkest">
        Issues
      </h2>
      <ul class="px-6 pb-6">
        <li
          v-for="issue in project.issues"
          :key="issue.node_id"
          class="mt-6"
        >
          <div class="flex flex-col w-auto">
            <div class="flex items-baseline justify-between">
              <inertia-link
                class="text-black-lighter font-medium no-underline leading-normal truncate flex-1"
                href="/issue"
                method="post"
                target="_blank"
                preserve-state
                :data="{ project: project, issue: issue }"
              >
                {{ issue.title }}
              </inertia-link>
              <a
                class="no-underline"
                :href="issue.html_url"
                target="_blank"
                aria-label="Launch"
              >
                <IconLaunch />
              </a>
            </div>
            <div>
              <a
                class="text-indigo no-underline"
                :href="issue.user.html_url"
                target="_blank"
              >
                @{{ issue.user.login }}
              </a>
              |
              <span class="font-semibold text-grey-darkest">
                {{ $luxon.fromISO(issue.created_at).toRelative() }}
              </span>
              <div v-if="Object.keys(issue.labels).length > 0">
                <a
                  v-for="label in issue.labels"
                  :key="label.name"
                  class="mr-2 mt-1 inline-flex items-center px-2 py-1 bg-grey-blue hover:bg-grey-blue-light text-grey-blue-darkest font-sans font-semibold no-underline leading-none text-xs capitalize rounded-lg"
                  :href="'https://github.com/' + project.namespace + '/' + project.name + '/labels/' + label.name"
                  target="_blank"
                >
                  <span
                    class="rounded-full w-3 h-3"
                    :style="'background-color: #' + label.color"
                  />
                  <span class="ml-1">
                    {{ label.name }}
                  </span>
                </a>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </section>
  </layout>
</template>

<script>
import Layout from '../Layout';
import IconLaunch from '../../components/svg/Launch';
import GoBack from '../../components/GoBack';
import ProjectHeader from '../Partials/ProjectHeader';

export default {
    components: {
        ProjectHeader,
        GoBack,
        IconLaunch,
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
