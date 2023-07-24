
<script>
import axios from 'axios';
export default {
  data() {
    return {
      users: [],
      currentUserId: 0,
      selectedUserName: '',
      lookList:false,
      lookChat:false,
    };

  },
  
  mounted() {
    axios
      .get('/user', {
        params: {
          currentUserId: this.currentUserId
        }
      })
      .then(response => {
        // handle success
        this.users = response.data.users; // users配列を受け取る
        this.currentUserId = response.data.currentUserId;
      })
  },
  methods: {
    selectUser(userName) { // 追加: ユーザ名を選択するメソッド
      this.selectedUserName = userName;
      this.lookList = !this.lookList;
      this.lookChat = !this.lookChat;

    },
    
  },
};
</script>
<template>
  <div class="parentBox">

    <div class="childrenBox1" :class="{ active1: lookList}">
      <h1>TALK ROOM</h1>
        <ul>
          <li v-for="user in users" :key="user.id">
            <router-link 
            :to="{ name: 'Chat', params: { linkId: user.id, userId: currentUserId} }" 
            :key="user.id"
            @click="selectUser(user.name)"
            >{{ user.name }}</router-link>
          </li>
        </ul>
    </div>
    
    <div  class="childrenBox2" :class="{ active2: lookChat}">
      <router-view :selectedUserName="selectedUserName" :users="users" ref="child" :class="{ active2: lookChat}"></router-view>
    </div>

  </div>
</template>



<style>
h1{ 
  font-family:fantasy;
  text-align: left;
  padding: 10px 15px;
  font-size: 22px;
  border-bottom: thin solid #d8d2d2;
}
p{

  text-align: left;
}
li{
  border-bottom: thin solid #d8d2d2;
  margin: 5px 0;
  padding:15px;
}
.parentBox{
  display: flex;
  height: 100vh;
}
.childrenBox1 {
  width: calc( 100% / 4*1 );
  background-color: #fdffff;
  border:1px solid #000000;
  overflow-y: scroll;
  height:100%;
}
.childrenBox2 {
  width: calc( 100% / 4*3 );
  background-color: #e5e3e3;
  border:1px solid #000000;
  height:100%;
}

@media screen and (max-width: 500px) {
  .childrenBox1 {
  width:100%;
}
.childrenBox2 {
  width: 0%;
}

  .active1 {
        width:0%;
    }
  .active2{
      width:100%;
    }
}

</style>