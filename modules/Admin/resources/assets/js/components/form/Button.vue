<template>
  <button :class="buttonClass" class="w-60 h-14 px-6 py-2 rounded-[28px] my-2 md:my-0">
    <slot>
      <span class="">ボタン</span>
    </slot>
  </button>
</template>

<script>
export default {
  name: "ButtonComponent",
  props: {
    buttonType: {
      type: String,
      default: "primary", // default type
    },
  },
  computed: {
    buttonClass() {
      switch (this.buttonType) {
        case "secondary":
          return "bg-neutral-400 text-white";
        case "primary":
          return "bg-brand-color";
        case "white":
          return "bg-white border border-neutral-400";
        case "deactive":
          return "bg-neutral-400";
        default:
          return "bg-brand-color text-white"; // Fallback to primary style
      }
    },
  },
};
</script>
