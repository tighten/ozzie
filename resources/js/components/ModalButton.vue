<template>
  <div>
    <button
      class="mt-1 h-6 inline-flex items-center px-2 py-1 bg-grey-blue hover:bg-grey-blue-light text-grey-blue-darkest font-sans font-semibold no-underline leading-none text-xs capitalize rounded"
      @click="show"
    >
      Details
    </button>
  </div>
</template>

<script>
export default {
    props: {
        'modalId': {
            required: true,
            type: String,
        },
    },
    methods: {
        show() {
            this.$modal.show(this.modalId);
        },
    },
};
</script>
