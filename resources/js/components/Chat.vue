
<script>
export default {
  data(){
    return {
      message:'',
      chat:{
        message:[],
      }
    }
  },
  methods:{
    send(){
      if(this.message.length !=0){
        this.chat.message.push(this.message)
        this.message='';
      }
    }
  }
}
</script>

<template>
  <message v-for="message in chat.message">
  {{ message }}
                    </message>
                    <input type="text" placeholder="Type your message here.." v-model="message">
                    <button @click="send">
                        SEND
                    </button>
</template>

<style>
h3{
  background-color: #fcf9f9;
  text-align: right;
}

input{
  border-radius: 10px;
}

button{
  background-color:black;
  font-family:fantasy;
  color: #fcf9f9;
  padding: 5px 10px;
  border-radius: 5px;
  margin-left:10px;
}
</style>