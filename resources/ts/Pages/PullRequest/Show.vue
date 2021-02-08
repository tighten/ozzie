<template>
  <GithubItem
    :project-namespace="project.namespace"
    :project-name="project.name"
    :project-maintainers="project.maintainers"
    :project-url="project.url"
    :github-item-title="pullRequest.title"
    :github-item-number="pullRequest.number"
    :github-item-body="pullRequest.body"
    :github-item-html-url="pullRequest.html_url"
    :github-item-user-url="pullRequest.user.html_url"
    :github-item-user-login="pullRequest.user.login"
    :github-item-created-at="pullRequest.created_at"
  >
    <template #github-item-type>
      Pull Request
    </template>
    <template #title-extra>
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
    </template>
  </GithubItem>
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
    pullRequest: {
      required: true,
      type: Object,
    },
  },
  methods: {
    baseUrl(section) {
      return (section)
        ? `${this.pullRequest.html_url}/${section}`
        : this.pullRequest.html_url;
    },
  },
};
</script>
