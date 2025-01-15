<template>
    <div v-if="messages && messages.length" class="text-red-600 text-sm mt-2">
      <ul>
        <li v-for="(message, index) in messages" :key="index">{{ message }}</li>
      </ul>
    </div>
  </template>

  <script>
  export default {
    props: {
      messages: { type: Array, default: () => [] },
    },
  };
  </script>
