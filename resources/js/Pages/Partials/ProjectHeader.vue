<template>
  <section
    :id="'project-' + namespace + '-' + name"
    class="items-center pb-6"
  >
    <h2 class="text-3xl text-black-lightest font-semibold tracking-wide">
      <a
        :href="url"
        aria-label="Launch"
      >
        {{ namespace }} | {{ name }}
        <IconLaunch />
      </a>
    </h2>

    <p class="text-black-lightest">
      Maintained by
      <a
        v-for="maintainer in maintainers"
        :key="maintainer"
        class="text-indigo no-underline"
        :href="'https://github.com/' + maintainer"
        target="_blank"
      >
        @{{ maintainer }}
      </a>
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
        namespace: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
        maintainers: {
            type: Array,
            required: true,
        },
    },
};
</script>
