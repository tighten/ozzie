<template>
  <layout title="Ozzie">
    <div class="flex items-center justify-between">
      <p class="mb-6 text-black-lighter">
        Projects in descending order of "debt" (how much attention it needs)
      </p>

      <a
        v-if="hacktoberfest"
        href="https://github.com/search?o=desc&amp;q=label%3Ahacktoberfest+is%3Aopen+type%3Aissue+user%3Atighten&amp;s=created&amp;type=Issues"
        target="_blank"
        class="mb-6 px-4 py-3 bg-grey-blue hover:bg-halloween-orange no-underline rounded-lg text-black-lighter hover:text-white hover-pop"
      >
        Hacktoberfest is here! 👻
      </a>
    </div>
    <div class="overflow-x-auto max-w-full">
      <table class="table-auto rounded-lg shadow w-full">
        <thead class="bg-grey-blue-light border-grey border-b-2 text-left">
          <tr>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">
              Project Name
            </th>
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
            <th
              v-if="hacktoberfest"
              class="text-xs p-4"
            >
              🎃
            </th>
          </tr>
        </thead>

        <tbody class="bg-white rounded-b-lg divide-y divide-smoke">
          <tr
            v-for="project in projects"
            :key="project.name"
          >
            <td class="p-4">
              <inertia-link
                class="text-indigo no-underline p-2 -mx-2"
                href="/projects"
                method="get"
                :data="{ namespace: project.namespace, name: project.name }"
              >
                {{ project.namespace }}/{{ project.name }}
              </inertia-link>
            </td>
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
            <td
              v-if="hacktoberfest"
              class="p-4"
            >
              <a
                class="text-indigo no-underline p-2 -mx-2"
                :href="'https://github.com/' + project.namespace + '/' +project.name + '/labels/hacktoberfest'"
                target="_blank"
              >
                {{ project.hacktoberfestIssues }}
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </layout>
</template>

<script>
import Layout from '../Layout';
export default {
    components: {
        Layout,
    },
    props: {
        projects: {
            type: Array,
            required: true,
        },
        hacktoberfest: {
            type: Boolean,
            required: true,
        },
    },
};
</script>
