<template>
  <GithubItem
    :project="project"
    :issue="issue"
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
