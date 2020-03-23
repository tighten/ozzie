<template>
    <div>
        <button @click="show" class="h-8 inline-flex items-center px-2 py-2 bg-grey-blue hover:bg-grey-blue-light text-grey-blue-dark font-open-sans font-semibold no-underline leading-none text-xs capitalize rounded">View description
    </button>
    </div>
</template>

<script>
export default {
    props: {
      'modalId': {
          required: true
      }
    },
    methods: {
        show () {
            this.$modal.show(this.modalId);
        },
        hide () {
            this.$modal.hide(this.modalId);
        }
    }
}
</script>
