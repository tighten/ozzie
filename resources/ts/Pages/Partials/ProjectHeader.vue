<template>
  <section
    :id="`project-${project.namespace}-${project.name}`"
    class="items-center pb-6"
  >
    <div class="flex justify-between items-center">
      <h2 class="text-3xl text-black-lightest font-semibold tracking-wide">
        <a
          :href="project.url"
          aria-label="Launch"
        >
          {{ project.namespace }} | {{ project.name }}
          <IconLaunch />
        </a>
      </h2>
      <p class="text-black-lightest">
        Maintained by
        <a
          v-for="maintainer in project.maintainers"
          :key="maintainer"
          class="text-indigo no-underline"
          :href="`https://github.com/${maintainer}`"
          target="_blank"
        >
          @{{ maintainer }}
        </a>
      </p>
    </div>
    <p class="mt-1 text-grey-dark font-light">
      Synced {{ $luxon.fromISO(project.updated_at).toRelative() }}
    </p>
  </section>
</template>

<script>
import IconLaunch from '../../components/svg/Launch';

export default {
  name: 'ProjectHeader',
  components: {
    IconLaunch,
  },
  props: {
    project: {
      type: Object,
      required: true,
    },
  },
};
</script>
