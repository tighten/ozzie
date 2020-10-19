<template>
  <layout :title="'Ozzie - ' + project.namespace + '/' + project.name + ' - pull request #' + issue.number">
    <GoBack />
    <ProjectHeader
      :namespace="project.namespace"
      :name="project.name"
      :url="project.url"
      :maintainers="project.maintainers"
    />
    <div class="flex flex-col bg-white rounded shadow">
      <span class="border-grey border-b-2 p-4 bg-grey-blue-light uppercase text-xs leading-none tracking-wide font-bold text-grey-darkest">
        Issue
      </span>
      <div class="px-6 py-2">
        <h2 class="mt-0 text-2xl text-black font-semibold tracking-wide">
          {{ issue.title }}
          <span class="ml-2 text-grey-dark font-normal">
            #{{ issue.number }}
          </span>
        </h2>
        <div
          v-if="loaded"
          class="mt-4 markdown-body"
        >
          <div
            v-if="issueBody !== ''"
            class="pt-4 border-t border-clouds"
          >
            <article v-html="issueBody" />
          </div>
          <em
            v-else
            class="text-grey-darker"
          >No description provided.</em>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from '../Layout';
import GoBack from '../../components/GoBack';
import ProjectHeader from '../Partials/ProjectHeader';

export default {
    components: {
        GoBack,
        Layout,
        ProjectHeader,
    },
    props: {
        project: {
            required: true,
            type: Object,
        },
        issue: {
            required: true,
            type: Object,
        },
    },
    data() {
        return {
            issueBody: '',
            loaded: false,
        };
    },
    mounted() {
        window.axios
            .post('https://api.github.com/markdown',
                {
                    text: this.issue.body,
                },
                {
                    headers: {
                        Authorization: `token ${window.githubToken}`,
                    },
                }
            )
            .then(response => {
                this.issueBody = response.data;
                this.loaded = true;
            })
            .catch(error => console.log(error.message));
    },
    methods: {
        baseUrl(section) {
            return (section)
                ? this.issue.url + '/' + section
                :this.issue.url;
        },
    },
};
</script>
