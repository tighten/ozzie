<template>
  <div class="flex flex-col w-auto">
    <div class="flex items-baseline justify-between">
      <slot name="link" />
      <a
        class="no-underline"
        :href="gitHubItem.html_url"
        target="_blank"
        aria-label="Launch"
      >
        <IconLaunch />
      </a>
    </div>
    <div>
      <a
        class="text-indigo no-underline"
        :href="gitHubItem.user.html_url"
        target="_blank"
      >
        @{{ gitHubItem.user.login }}
      </a>
      |
      <span class="font-semibold text-grey-darkest">
        {{ $luxon.fromISO(gitHubItem.created_at).toRelative() }}
      </span>
      <div v-if="Object.keys(gitHubItem.labels).length > 0">
        <a
          v-for="label in gitHubItem.labels"
          :key="label.name"
          class="mr-2 mt-1 inline-flex items-center px-2 py-1 bg-grey-blue hover:bg-grey-blue-light text-grey-blue-darkest font-sans font-semibold no-underline leading-none text-xs capitalize rounded-lg"
          :href="'https://github.com/' + projectNamespace + '/' + projectName + '/labels/' + label.name"
          target="_blank"
        >
          <span
            class="rounded-full w-3 h-3"
            :style="'background-color: #' + label.color"
          />
          <span class="ml-1">
            {{ label.name }}
          </span>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import IconLaunch from '../../components/svg/Launch';

export default {
  name: 'GithubListItem',
  components: { IconLaunch },
  props: {
    projectName: {
      required: true,
      type: String,
    },
    projectNamespace: {
      required: true,
      type: String,
    },
    gitHubItem: {
      required: true,
      type: Object,
    },
  },
};
</script>
