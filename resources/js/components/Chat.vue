<template>
  <div v-for="message in chat.message">
    {{ message }}
  </div>
  <input type="text" placeholder="Type your message here.." v-model="message">
  <button @click="send" >
      SEND
  </button>
</template>

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
  mounted(){
        window.Echo.private('dashboard')
        .listen('ChatEvent', (e) => {
            console.log(e);
        });
    },

  methods:{
    send(){
      if(this.message.length !=0){
        this.chat.message.push(this.message)
        this.message='';
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
                this.messages = response.data;
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
</style>