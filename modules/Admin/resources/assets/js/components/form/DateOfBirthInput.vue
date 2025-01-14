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
        v-model="year"
        as="select"
        name="dob_year"
        @input="changeYear"
        class="form-select border px-3 py-3 mr-2 w-[36%] focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md shadow-md">
        <option v-for="year in years" :value="year" :key="year">{{ year }}</option>
      </Field>
      <span class="text-base w-[8%] text-center">年</span>
      <Field
        v-model="month"
        as="select"
        name="dob_month"
        @input="changeMonth"
        class="form-select border px-3 py-3 mr-2 w-[20%] focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md shadow-md">
        <option v-for="month in months" :value="month" :key="month">{{ month }}</option>
      </Field>
      <span class="text-base text-center w-[8%]">月</span>
      <Field
        v-model="date"
        as="select"
        name="dob_date"
        @input="changeDate"
        class="form-select border px-3 py-3 mr-2 w-[20%] focus:outline-none focus:border-brand-color focus:ring-1 focus:ring-brand-color rounded-md shadow-md">
        <option v-for="day in days" :value="day" :key="day">{{ day }}</option>
      </Field>
      <span class="text-base text-center w-[8%]">日</span>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, computed } from 'vue'

const props = defineProps(['label', 'isRequired', 'dob'])
const emits = defineEmits(['update:modelValue'])
const year = ref(null)
const month = ref(null)
const date = ref(null)
const years = ref(Array.from({ length: new Date().getFullYear() - 1900 }, (_, i) => 1900 + i).reverse())
const months = ref(Array.from({ length: 12 }, (_, i) => i + 1 + ''))
const days = ref([])
const changeYear = (e) => {
  const lastDay = new Date(e.target.value, month.value, 0).getDate()
  days.value = Array.from({ length: lastDay }, (_, i) => (i + 1 + ''))
  year.value = e.target.value
  emits('update:modelValue', { year: e.target.value, month: month.value, date: date.value })
}
const changeMonth = (e) => {
  const lastDay = new Date(year.value, e.target.value, 0).getDate()
  days.value = Array.from({ length: lastDay }, (_, i) => (i + 1))
  month.value = e.target.value
  emits('update:modelValue', { year: year.value, month: e.target.value, date: date.value })
}
const changeDate = (e) => {
  emits('update:modelValue', { year: year.value, month: month.value, date: e.target.value })
}

</script>
