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
    <div class="flex items-center justify-between">
      <Field
        v-model="firstValue"
        name="tel_first"
        type="text"
        maxlength="3"
        class="border px-3 py-3 focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md w-[30%] shadow-md"
        @input="updateFirstValue"
        @keypress="checkDigit"
        @paste="checkPaste"
      />
      <span class="text-base w-[4%] text-center">-</span>
      <Field
        v-model="middleValue"
        name="tel_middle"
        type="text"
        maxlength="4"
        class="border px-3 py-3 focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md w-[30%] shadow-md"
        @input="updateMiddleValue"
        @keypress="checkDigit"
        @paste="checkPaste"
      />
      <span class="text-base text-center w-[4%]">-</span>
      <Field
        v-model="lastValue"
        name="tel_last"
        type="text"
        maxlength="4"
        class="border px-3 py-3 focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md w-[30%] shadow-md"
        @input="updateLastValue"
        @keypress="checkDigit"
        @paste="checkPaste"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue'

// eslint-disable-next-line no-unused-vars
const props = defineProps(['label', 'isRequired'])
const emits = defineEmits(['update:modelValue'])

const firstValue = ref('')
const middleValue = ref('')
const lastValue = ref('')

const updateFirstValue = (e) => {
  emits('update:modelValue', { first: e.target.value, middle: middleValue.value, last: lastValue.value })
}
const updateMiddleValue = (e) => {
  emits('update:modelValue', { first: firstValue.value, middle: e.target.value, last: e.target.value })
}
const updateLastValue = (e) => {
  emits('update:modelValue', { first: firstValue.value, middle: middleValue.value, last: e.target.value })
}

const checkDigit = (e) => {
  if (e.charCode < 48 || e.charCode > 57) {
    e.preventDefault();
  }
}

const checkPaste = (e) => {
  const pastedData = e.clipboardData?.getData('text');
  if (/\D/.test(pastedData.trim() || '')) {
    e.preventDefault();
  }
};
</script>
