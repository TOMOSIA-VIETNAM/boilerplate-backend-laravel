<template>
  <div
    v-show="isOpen"
    class="fixed z-20 inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50"
  >
    <div class="p-6 mx-4 bg-white rounded-md shadow-xl w-[400px] max-w-[80%]">
      <div class="flex items-center justify-between">
        <h3 class="text-md text-center w-full mb-4">{{ title }}</h3>
      </div>
      <div class="mt-4 text-gray-600">
        <slot></slot>
      </div>
      <div class="flex justify-center mt-8">
        <button
          @click="closeModal"
          class="w-[300px] px-6 py-2 text-white bg-yellow-400 rounded-full"
        >
          閉じる
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({ isOpen: Boolean, title: { default: '', type: String } })
const emit = defineEmits()

const closeModal = () => {
  emit('close')
}
</script>
