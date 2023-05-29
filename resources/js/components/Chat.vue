<template>
  <div class="message-container">
    <div v-for="message in chat.message">
      {{ message }}
    </div>
    <div class="user-area">
      <input type="text" name="message" placeholder="Type your message here.." v-model="message">
      <button @click="send">
          SEND
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['linkId', 'userId'],
  data(){
    return {
      message:'',
      chat:{
        message:[],
      },
    }
  },
  
  mounted(){
        this.fetchMessages();
        window.Echo.private('chat')
        .listen('ChatEvent', (e) => {
            console.log(e);
            // this.chat.message.push(e.message);
            if (e.linkId === this.linkId && e.userId === this.userId) {
          this.messages.push(e.message);
        }})
        .here((users) => {
      const currentUser = users.find(user => user.id === this.currentUserId);
      if (currentUser) {
        // ユーザーIDを取得できた場合、処理を行う
        console.log('Current user:', currentUser);
      }
    });
    },
  methods:{
    send(){
      if(this.message.length !=0){
        this.chat.message.push(this.message)
        // this.message='';
        axios.post('/send', {
      message: this.message
      })
      .then(response => {
        console.log(response);
        this.message = '';
      })
      .catch(error => {
        console.log(error);
      });
      }
    },
    fetchMessages(){
            //GET request to the messages route in our Laravel server to fetch all the messages
            axios.get('/message').then(response => {
                //Save the response in the messages array to display on the chat view
                this.message = response.data;
            });
        },
    
  }
}

</script>
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

.message-container {
  position: relative;
  padding-bottom: 3rem;
}

.user-area{
  position: absolute;
  bottom: 0;
}
</style>