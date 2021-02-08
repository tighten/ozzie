<template>
  <Layout :title="'Ozzie - ' + projectNamespace + '/' + projectName + ' - #' + githubItemNumber">
    <GoBack />
    <ProjectHeader
      :namespace="projectNamespace"
      :name="projectName"
      :url="projectUrl"
      :maintainers="projectMaintainers"
    />
    <Card>
      <CardHeader>
        <div class="flex justify-between">
          <!-- ITEM TYPE -->
          <Slot name="github-item-type" />
          <span class="normal-case font-normal">opened by <a
            class="font-semibold text-indigo"
            :href="githubItemUserUrl"
            target="_blank"
          >
            {{ githubItemUserLogin }}
          </a> {{ $luxon.fromISO(githubItemCreatedAt).toRelative() }}
          </span>
        </div>
      </CardHeader>
      <CardBody>
        <h2 class="mt-0 text-xl text-black font-semibold tracking-wide leading-none truncate">
          {{ githubItemTitle }}
          <span class="ml-2 text-grey-dark font-normal">
            #{{ githubItemNumber }}
          </span>
        </h2>

        <!-- TITLE EXTRA -->
        <slot name="title-extra" />

        <div
          v-if="loaded"
          class="mt-4 markdown-body"
        >
          <div
            v-if="githubItemBody !== ''"
            class="pt-4 border-t border-clouds"
          >
            <article v-html="parsedGithubItemBody" />
          </div>
          <em
            v-else
            class="text-grey-darker"
          >No description provided.</em>
        </div>
      </CardBody>
    </Card>
  </Layout>
</template>

<script>
import Layout from '../Layout';
import GoBack from '../../components/GoBack';
import ProjectHeader from './ProjectHeader';
import Card from '../../components/Card';
import CardBody from '../../components/CardBody';
import CardHeader from '../../components/CardHeader';

export default {
  components: {
    CardHeader,
    CardBody,
    Card,
    GoBack,
    Layout,
    ProjectHeader,
  },
  props: {
    projectNamespace: {
      required: true,
      type: String,
    },
    projectName: {
      required: true,
      type: String,
    },
    projectUrl: {
      required: true,
      type: String,
    },
    projectMaintainers: {
      required: true,
      type: Array,
    },
    githubItemTitle: {
      required: true,
      type: String,
    },
    githubItemNumber: {
      required: true,
      type: Number,
    },
    githubItemBody: {
      required: true,
      type: String,
    },
    githubItemHtmlUrl: {
      required: true,
      type: String,
    },
    githubItemUserUrl: {
      required: true,
      type: String,
    },
    githubItemUserLogin: {
      required: true,
      type: String,
    },
    githubItemCreatedAt: {
      required: true,
      type: String,
    },
  },
  data() {
    return {
      parsedGithubItemBody: '',
      loaded: false,
    };
  },
  mounted() {
    this.$http.post('https://api.github.com/markdown',
      {
        text: this.githubItemBody,
      },
      {
        headers: {
          Authorization: `token ${window.githubToken}`,
        },
      })
      .then((response) => {
        this.parsedGithubItemBody = response.data;
        this.loaded = true;
      })
      .catch((error) => console.log(error.message));
  },
  methods: {
    baseUrl(section) {
      return (section)
        ? `${this.githubItemHtmlUrl}/${section}`
        : this.githubItemHtmlUrl;
    },
  },
};
</script>
