
<script>
import axios from 'axios';
export default {
  data() {
    return {
      users: [],
      currentUserId: 0,
      selectedUserName: '',
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
        console.log(response.data);
      })
      .catch(error => {
        // handle error
        console.log(error);
      });
  },
  methods: {
    selectUser(userName) { // 追加: ユーザ名を選択するメソッド
      this.selectedUserName = userName;
    },
    
  },
};
</script>
<template>
  <div class="parentBox">

    <div class="childrenBox1">
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
    
    <div  class="childrenBox2">
      <router-view :selectedUserName="selectedUserName" ref="child"></router-view>
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
}
.childrenBox1 {
  width: calc( 100% / 4*1 );
  background-color: #fdffff;
  border:1px solid #000000;
  overflow-y: scroll;
  height: 550px;
}
.childrenBox2 {
  width: calc( 100% / 4*3 );
  background-color: #e5e3e3;
  border:1px solid #000000;
}
</style>