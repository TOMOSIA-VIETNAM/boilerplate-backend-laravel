<template>
  <div class="h-16 flex flex-col items-center gap-6 w-full">
    <div
      class="text-center text-gray-900 text-xl font-bold  w-full py-5"
    >
      <!-- テキストをpropsから受け取るように変更 -->
      {{ title }}
    </div>
  </div>
</template>

<script>
export default {
  // propsの定義を追加
  props: {
    title: {
      type: String,
      default: "アカウント", // デフォルト値を設定
    },
  },
};
</script>
