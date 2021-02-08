<template>
  <span class="inline-flex text-indigo">
    <button
      type="button"
      class="-ml-2 inline-flex items-center text-sm leading-4 font-medium focus:outline-none focus:border-indigo"
      onclick="history.back()"
    >
      <IconChevronLeft />
      back
    </button>
  </span>
</template>

<script>
import IconChevronLeft from './svg/ChevronLeft';

export default {
  name: 'GoBack',
  components: {
    IconChevronLeft,
  },
};
</script>
