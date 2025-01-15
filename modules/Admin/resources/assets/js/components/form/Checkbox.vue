<template>
    <div class="flex items-center mb-4">
      <input
        type="checkbox"
        :id="id"
        :name="name"
        :checked="checked"
        @change="$emit('update:checked', $event.target.checked)"
        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
      />
      <label :for="id" class="ml-2 block text-sm text-gray-700">{{ label }}</label>
    </div>
  </template>

  <script>
  export default {
    props: {
      label: { type: String, required: true },
      id: { type: String, required: true },
      name: { type: String, required: true },
      checked: { type: Boolean, default: false },
    },
  };
  </script>
