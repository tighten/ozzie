<template>
  <GithubItem
    :project-namespace="project.namespace"
    :project-name="project.name"
    :project-maintainers="project.maintainers"
    :project-url="project.url"
    :github-item-title="issue.title"
    :github-item-number="issue.number"
    :github-item-body="issue.body"
    :github-item-html-url="issue.html_url"
    :github-item-user-url="issue.user.html_url"
    :github-item-user-login="issue.user.login"
    :github-item-created-at="issue.created_at"
  >
    <template #github-item-type>
      Issue
    </template>
  </GithubItem>
</template>

<script>
import GithubItem from '../Partials/GithubItem';

export default {
  components: {
    GithubItem,
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
};
</script>
