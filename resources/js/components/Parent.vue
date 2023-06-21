<script >
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
  </div>
</template>

<style scoped>
.container {
  display: flex;
}

.component {
  width: 100%;
  height: 100%;
}
</style>