<template>
  <div class="mb-1 w-full">
    <label class="flex justify-between items-center mb-2 text-xs">
      {{ label }}
      <span
        v-if="isRequired"
        class="text-xs border-[1px] border-red-500 text-red-500 rounded-md px-1"
        >必須</span
      >
    </label>
    <div class="flex items-center">
      <Field
        v-model="firstValue"
        :name="`${name}_first`"
        type="text"
        class="border px-3 py-3 mr-1 focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md w-1/2 shadow-md"
        placeholder="氏"
        @input="updateFirstValue"
      />

      <Field
        v-model="lastValue"
        :name="`${name}_last`"
        type="text"
        class="border px-3 py-3 focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md w-1/2 shadow-md"
        placeholder="名"
        @input="updateLastValue"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue'

const props = defineProps(['label', 'isRequired', 'name'])
const emits = defineEmits(['update:modelValue'])

const firstValue = ref('')
const lastValue = ref('')

const updateFirstValue = (e) => {
  emits('update:modelValue', { first: e.target.value, last: lastValue.value })
}

const updateLastValue = (e) => {
  emits('update:modelValue', { first: firstValue.value, last: e.target.value })
}
</script>
