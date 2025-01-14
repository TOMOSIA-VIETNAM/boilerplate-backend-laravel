<template>
  <button
    class="h-9 px-4 py-2 rounded-lg border text-sm font-normal flex items-center justify-center gap-2"
    :class="isSelected ? 'bg-sky-200 border-teal-500' : 'bg-white border-stone-300'"
    @click="$emit('select', minutes)"
  >
    <span class="text-gray-900">{{ minutes }}分</span>
    <!-- 選択中のアイコン表示 -->
    <img v-if="isSelected" src="@/assets/icons/CalenderCheck.svg" alt="" />
  </button>
</template>

<script>
export default {
  props: {
    minutes: {
      type: Number,
      default: 0,
    },
    selected: {
      type: Number,
      default: 0,
    },
  },
  computed: {
    isSelected() {
      return this.minutes === this.selected;
    },
  },
};
</script>
