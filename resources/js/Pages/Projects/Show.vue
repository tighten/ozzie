<template>
  <layout :title="'Ozzie - ' + project.namespace + '/' + project.name">
    <span class="inline-flex text-indigo">
      <button type="button" class="-ml-2 inline-flex items-center text-sm leading-4 font-medium focus:outline-none focus:border-indigo" onclick="history.back()">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        back
      </button>
    </span>

    <section :id="'project-' + project.namespace + '-' + project.name"
             class="flex justify-between items-center pb-6 border-b-2 border-clouds"
    >
      <h2 class="w-1/2 text-2xl text-black font-semibold tracking-wide">
        <a :href="project.url" aria-label="Launch">
          {{ project.namespace }} | {{ project.name }}
          <svg class="fill-current text-grey-blue-darkest inline-block w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>Launch</title>
            <path d="M0 0h24v24H0z" fill="none" />
            <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z" />
          </svg>
          <span class="sr-only">Launch</span>
        </a>
      </h2>

      <p class="w-1/2 text-right text-black-lightest">
        Maintained by
        <a v-for="maintainer in project.maintainers" :key="maintainer" class="text-indigo no-underline" :href="'https://github.com/' + maintainer" target="_blank">@{{ maintainer }} </a>
      </p>
    </section>

    <div class="overflow-x-auto max-w-full">
      <table class="table-auto rounded-lg shadow w-full">
        <thead class="bg-grey-blue-light border-grey border-b-2 text-left">
          <tr>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Debt Score</th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Old Prs</th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Old Issues</th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Prs</th>
            <th class="text-grey-darkest font-bold uppercase text-xs leading-none tracking-wide p-4">Issues</th>
          </tr>
        </thead>

        <tbody class="bg-white rounded-b-lg divide-y divide-smoke">
          <tr>
            <td class="text-black-lightest p-4">{{ project.debtScore }}</td>
            <td class="text-black-lightest p-4">{{ project.oldPrCount }}</td>
            <td class="text-black-lightest p-4">{{ project.oldIssueCount }}</td>
            <td class="text-black-lightest p-4">{{ project.prCount }}</td>
            <td class="text-black-lightest p-4">{{ project.issueCount }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <section v-if="Object.keys(project.prs).length > 0" class="flex items-start border-b border-clouds">
      <h3 class="w-1/3 text-lg text-black-lightest py-6 font-thin">Pull Requests</h3>
      <ul class="w-2/3">
        <li v-for="pr in project.prs" :key="pr.node_id" class="flex flex-col">
          <div class="flex justify-between">
            <div class="py-6 w-auto">
              <p>
                <inertia-link
                  class="text-black-lighter font-medium no-underline leading-normal"
                  href="/pr"
                  method="post"
                  target="_blank"
                  preserve-state
                  :data="{ project: project, pr: pr }"
                >
                  {{ pr.title }}
                </inertia-link>
              </p>
              <div>
                <a class="text-indigo no-underline" :href="pr.user.html_url" target="_blank">
                  @{{ pr.user.login }}
                </a>
                |
                <span class="font-semibold text-grey-darkest">
                  {{ $luxon.fromISO(pr.created_at).toRelative() }}
                </span>
                <div v-if="Object.keys(pr.labels).length > 0">
                  <a v-for="label in pr.labels" :key="label.name" class="mt-1 inline-flex items-center px-2 py-1 bg-grey-blue hover:bg-grey-blue-light text-grey-blue-darkest font-sans font-semibold no-underline leading-none text-xs capitalize rounded-lg"
                     :href="'https://github.com/' + project.namespace + '/' + project.name + '/labels/' + label.name"
                     target="_blank"
                  >
                    <span class="rounded-full w-3 h-3" :style="'background-color: #' + label.color" />
                    <span class="ml-1">{{ label.name }}</span>
                  </a>
                </div>
              </div>
            </div>
            <div class="flex h-10 py-6 w-auto">
              <div v-cloak />
              <a class="no-underline" :href="pr.html_url" target="_blank" aria-label="Launch">
                <svg class="fill-current text-grey-blue-darkest inline-block w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <title>Launch</title>
                  <path d="M0 0h24v24H0z" fill="none" />
                  <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z" />
                </svg>
                <span class="sr-only">Launch</span>
              </a>
            </div>
          </div>
        </li>
      </ul>
    </section>
  </layout>
</template>

<script>
import Layout from '../Layout';

export default {
    components: {
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
