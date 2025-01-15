<template>
    <button
      :type="type"
      :class="['py-2 px-4 rounded-md focus:outline-none', buttonClass]"
      @click="$emit('click')"
    >
      <slot>Button</slot>
    </button>
  </template>

  <script>
  export default {
    props: {
      type: { type: String, default: 'button' },
      buttonType: { type: String, default: 'primary' },
    },
    computed: {
      buttonClass() {
        const classes = {
          primary: 'bg-blue-500 text-white hover:bg-blue-600',
          secondary: 'bg-gray-500 text-white hover:bg-gray-600',
          danger: 'bg-red-500 text-white hover:bg-red-600',
        };
        return classes[this.buttonType] || classes.primary;
      },
    },
  };
  </script>
