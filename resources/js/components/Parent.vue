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
      <List :linkId="user.id" :userId="currentUserId"/>
    </div>
    <div class="component">
      <Chat :linkId="user.id" :userId="currentUserId"/>
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