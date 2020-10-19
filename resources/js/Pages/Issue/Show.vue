<template>
  <layout :title="'Ozzie - ' + project.namespace + '/' + project.name + ' - issue #' + issue.number">
    <GoBack />
    <ProjectHeader
      :namespace="project.namespace"
      :name="project.name"
      :url="project.url"
      :maintainers="project.maintainers"
    />
    <card>
      <card-header>
        <div class="flex justify-between">
          <span>Issue</span>
          <opened-by :git-hub-item="issue" />
        </div>
      </card-header>
      <card-body>
        <h2 class="mt-0 text-2xl text-black font-semibold tracking-wide leading-none">
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
import OpenedBy from '../Partials/OpenedBy';

export default {
  components: {
    OpenedBy,
    CardBody,
    GoBack,
    Layout,
    ProjectHeader,
    Card,
    CardHeader,
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
