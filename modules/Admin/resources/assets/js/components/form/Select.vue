<template>
    <div class="mb-4">
      <label :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
      <select
        :id="id"
        :name="name"
        :value="value"
        @change="$emit('update:value', $event.target.value)"
        class="w-full mt-1 p-2 border border-gray-300 rounded-md"
      >
        <option v-for="(option, index) in options" :key="index" :value="option.value">
          {{ option.label }}
        </option>
      </select>
    </div>
  </template>

  <script>
  export default {
    props: {
      label: { type: String, required: true },
      id: { type: String, required: true },
      name: { type: String, required: true },
      value: { type: [String, Number], default: '' },
      options: { type: Array, required: true },
    },
  };
  </script>
