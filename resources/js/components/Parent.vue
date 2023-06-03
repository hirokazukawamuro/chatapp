<script >
import Chat from './Chat.vue'
import List from './List.vue'
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
  <div class="container">
    <div class="component">
      <List />
    </div>
    <div class="component">
      <Chat />
    </div>
  </div>
</template>

<style scoped>
.container {
  display: flex;
}

.component {
  flex: 1;
}
</style>