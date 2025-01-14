<template>
  <div class="flex w-full items-center py-6">
    <label class="w-24 text-xs mx-6">
      {{ label }}
    </label>
    <div class="w-[288px] text-base">
      {{ value }}
    </div>
  </div>
</template>

<script setup>
const props = defineProps(['label', 'value'])
</script>
