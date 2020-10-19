<template>
  <github-item
    :project-namespace="project.namespace"
    :project-name="project.name"
    :project-maintainers="project.maintainers"
    :project-url="project.url"
    :github-item-title="pr.title"
    :github-item-number="pr.number"
    :github-item-body="pr.body"
    :github-item-html-url="pr.html_url"
    :github-item-user-url="pr.user.html_url"
    :github-item-user-login="pr.user.login"
    :github-item-created-at="pr.created_at"
  >
    <template slot="github-item-type">
      Pull Request
    </template>
    <template slot="title-extra">
      <div class="mt-4 flex items-center text-black-lighter">
        <a
          class="flex items-center"
          :href="baseUrl()"
          target="_blank"
        >
          <icon-conversation />
          <span class="text-indigo">
            Conversation
          </span>
        </a>
        <a
          class="ml-8 flex items-center"
          :href="baseUrl('commits')"
          target="_blank"
        >
          <icon-commit />
          <span class="text-indigo">
            Commits
          </span>
        </a>
        <a
          class="ml-8 flex items-center"
          :href="baseUrl('files')"
          target="_blank"
        >
          <icon-file-diff />
          <span class="text-indigo">
            Files changed
          </span>
        </a>
      </div>
    </template>
  </github-item>
</template>

<script>
import GithubItem from '../Partials/GithubItem';
import IconCommit from '../../components/svg/Commit';
import IconFileDiff from '../../components/svg/FileDiff';
import IconConversation from '../../components/svg/Conversation';

export default {
  components: {
    IconConversation,
    IconCommit,
    IconFileDiff,
    GithubItem,
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
  methods: {
    baseUrl(section) {
      return (section)
        ? this.pr.html_url + '/' + section
        :this.pr.html_url;
    },
  },
};
</script>
