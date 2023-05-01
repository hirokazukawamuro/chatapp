<script >
import Chat from './Chat.vue'
import { onMounted } from 'vue'
export default ({
  setup() {
    console.log("start vue")

    onMounted(() => {
      console.log('start mounted !')
    })
  },
})
</script>
<template>
  <List />
  <Chat />
</template>

