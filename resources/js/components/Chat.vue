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
  data(){
    return {
      message:'',
      chat:{
        message:[],
      },
    }
  },
  // created() {
  //       this.fetchMessages();
  //       window.Echo.private('chat')
  //       .listen('ChatEvent', (e) => {
  //       this.messages.push({
  //     message: e.message.message,
  //     user: e.user});
  //   });
  //   },
  mounted(){
        window.Echo.private('chat')
        .listen('ChatEvent', (e) => {
            console.log(e);
            this.chat.message.push(e.message);
        });
    },
  methods:{
    //仮案↓
    // multipleMethod() {
    //   this.send();
    //   this.fetchMessages();
    //   this.addMessage();
    // },
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
            axios.get('/messages').then(response => {
                //Save the response in the messages array to display on the chat view
                this.message = response.data;
            });
        },
        //Receives the message that was emitted from the ChatForm Vue component
        addMessage(message) {
            //Pushes it to the messages array
            this.messages.push(message);
            //POST request to the messages route with the message data in order for our Laravel server to broadcast it.
            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        }
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