<template>
  <span class="normal-case font-normal">opened by <a
    class="font-semibold text-indigo"
    :href="gitHubItem.user.html_url"
    target="_blank"
  >
    {{ gitHubItem.user.login }}
  </a> {{ $luxon.fromISO(gitHubItem.created_at).toRelative() }}
  </span>
</template>

<script>
export default {
  name: 'OpenedBy',
  props: {
    gitHubItem: {
      required: true,
      type: Object,
    },
  },
};
</script>
