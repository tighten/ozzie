<template>
  <layout :title="'Ozzie - ' + project.namespace + '/' + project.name + ' - pull request #' + pr.number">
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
          <span>Pull Request</span>
          <opened-by :git-hub-item="pr" />
        </div>
      </card-header>
      <card-body>
        <h2 class="mt-0 text-2xl text-black font-semibold tracking-wide leading-none">
          {{ pr.title }}
          <span class="ml-2 text-grey-dark font-normal">
            #{{ pr.number }}
          </span>
        </h2>
        <div class="mt-4 flex items-center text-black-lighter">
          <a
            class="flex items-center"
            :href="baseUrl()"
            target="_blank"
          >
            <IconConversation />
            <span class="text-indigo">
              Conversation
            </span>
          </a>
          <a
            class="ml-8 flex items-center"
            :href="baseUrl('commits')"
            target="_blank"
          >
            <IconCommit />
            <span class="text-indigo">
              Commits
            </span>
          </a>
          <a
            class="ml-8 flex items-center"
            :href="baseUrl('files')"
            target="_blank"
          >
            <IconFileDiff />
            <span class="text-indigo">
              Files changed
            </span>
          </a>
        </div>
        <div
          v-if="loaded"
          class="mt-4 markdown-body"
        >
          <div
            v-if="prBody !== ''"
            class="pt-4 border-t border-clouds"
          >
            <article v-html="prBody" />
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
import IconConversation from '../../components/svg/Conversation';
import IconCommit from '../../components/svg/Commit';
import IconFileDiff from '../../components/svg/Conversation';
import GoBack from '../../components/GoBack';
import ProjectHeader from '../Partials/ProjectHeader';
import Card from '../../components/Card';
import CardBody from '../../components/CardBody';
import CardHeader from '../../components/CardHeader';
import OpenedBy from '../Partials/OpenedBy';

export default {
  components: {
    OpenedBy,
    CardHeader,
    CardBody,
    Card,
    GoBack,
    IconFileDiff,
    IconCommit,
    IconConversation,
    Layout,
    ProjectHeader,
  },
  props: {
    project: {
      required: true,
      type: Object,
    },
    pr: {
      required: true,
      type: Object,
    },
  },
  data() {
    return {
      prBody: '',
      loaded: false,
    };
  },
  mounted() {
    window.axios
      .post('https://api.github.com/markdown',
        {
          text: this.pr.body,
        },
        {
          headers: {
            Authorization: `token ${window.githubToken}`,
          },
        }
      )
      .then(response => {
        this.prBody = response.data;
        this.loaded = true;
      })
      .catch(error => console.log(error.message));
  },
  methods: {
    baseUrl(section) {
      return (section)
        ? this.pr.html_url + '/' + section
        :this.pr.html_url;
    },
  },
};
</script>
