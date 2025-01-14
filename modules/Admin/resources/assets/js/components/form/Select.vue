<template>
  <div class="mb-1 w-full">
    <label class="flex justify-between items-center mb-2 text-xs">
      {{ label }}
      <span
        v-if="isRequired"
        class="border-[1px] border-red-500 text-xs w-[40px] text-center px-1 text-red-500 rounded-md ml-2"
      >
        必須
      </span>
    </label>
    <div class="flex items-center">
      <Field
        v-model="selectedValue"
        :name="name"
        as="select"
        class="form-select border text-gray-500 px-3 py-3 focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md w-full shadow-md text-sm"
        @change="handleChange"
      >
        <option v-for="(item, index) in options" :value="getOptionValue(item)" :key="index">
          {{ getOptionText(item) }}
        </option>
      </Field>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue'

const props = defineProps(['label', 'name', 'options', 'isRequired', 'optionValue', 'optionText', 'defaultValue'])
const emits = defineEmits(['update:modelValue'])

const selectedValue = ref(props.defaultValue ?? '')

const handleChange = (event) => {
  selectedValue.value = event.target.value
  emits('update:modelValue', selectedValue.value)
}

const getOptionValue = (item) => item[props.optionValue]
const getOptionText = (item) => item[props.optionText]
</script>
