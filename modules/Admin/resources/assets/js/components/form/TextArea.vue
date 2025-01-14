<template>
  <div class="mb-1 w-full">
    <label class="flex justify-between rounded-md items-center mb-2">
      <span class="text-xs">{{ label }}</span>
      <span
        v-if="isRequired"
        class="text-xs border-[1px] border-red-500 text-red-500 rounded-md px-1"
      >
        必須
      </span>
    </label>

    <div class="flex items-center">
      <textarea
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :name="name"
        class="resize-none border px-3 py-3 focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md w-full shadow-md"
        :rows="4"
      ></textarea>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(["label", "modelValue", "name", "isRequired"]);
</script>
