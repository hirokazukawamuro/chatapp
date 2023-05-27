

<template>
   <h1>ユーザ一覧</h1>
    <ul>
      <li v-for="user in users">
        <router-link :to="`/chat/${user.id}`">{{ user.name }}</router-link>
      </li>
    </ul>
  
  </template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    axios
      .get('/user')
      .then(response => {
        // handle success
        this.users = response.data.users; // users配列を受け取る
        console.log(response.data);
      })
      .catch(error => {
        // handle error
        console.log(error);
      });
  },
};
</script>

<style>
h1{
  font-family:fantasy;
  text-align: left;
}
p{

  text-align: left;
}
</style>