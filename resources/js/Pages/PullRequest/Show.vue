<template>
  <layout :title="'Ozzie - ' + project.namespace + '/' + project.name + ' - pull request #' + pr.number">
    <GoBack />
    <ProjectHeader
      :namespace="project.namespace"
      :name="project.name"
      :url="project.url"
      :maintainers="project.maintainers"
    />
    <div class="flex flex-col bg-white rounded shadow">
      <span class="border-grey border-b-2 p-4 bg-grey-blue-light uppercase text-xs leading-none tracking-wide font-bold text-grey-darkest">
        Pull Request
      </span>
      <div class="px-6 py-2">
        <h2 class="mt-0 text-2xl text-black font-semibold tracking-wide">
          {{ pr.title }}
          <span class="ml-2 text-3xl text-grey-dark font-normal">
            #{{ pr.number }}
          </span>
        </h2>
        <p class="text-black-lighter">
          <a
            class="font-semibold text-indigo"
            :href="baseUrl('files')"
            target="_blank"
          >
            {{ pr.user.login }}
          </a>
          wants to merge into
          <span
            class="px-2 py-1 bg-indigo-lighter rounded font-mono text-sm text-indigo"
          >
            {{ pr.base.label }}</span>
          from
          <span
            class="px-2 py-1 bg-indigo-lighter rounded font-mono text-sm text-indigo"
          >
            {{ pr.head.label }}
          </span>
        </p>
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
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from '../Layout';
import IconConversation from '../../components/svg/Conversation';
import IconCommit from '../../components/svg/Commit';
import IconFileDiff from '../../components/svg/Conversation';
import GoBack from '../../components/GoBack';
import ProjectHeader from '../Partials/ProjectHeader';

export default {
    components: {
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
                ? this.pr.url + '/' + section
                :this.pr.url;
        },
    },
};
</script>
