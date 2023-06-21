<template>
  <div class="message-container" ref="messageContainer">
    <div :key="selectedUserName" class="who-you-talkto">
      {{"＜"+ selectedUserName }}
    </div>
    <div v-for="message in chat.message" :key="message.id" class="chat-word">
      {{ message.message}}
    </div>
    <div class="user-area">
      <div class="parts">
        <input type="text" name="message" placeholder="Type your message here.." v-model="message" class="input" @keypress="send">
        <button @click="send" class="sendbutton">
            SEND
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  
  name: 'Chat',
  props: {
    linkId: {
      type: [String, Number],
      required: true
    },
    userId: {
      type: [String, Number],
      required: true
    },
    selectedUserName:{
      type: String,
      required: true
    },
  },
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
          this.chat.message.push(e.message);
            console.log(e);
            this.fetchMessages();
            })
    },
  methods:{
    send() {
      if (this.message.length !== 0) {
        axios
        .post('/send', {
          message: this.message,
          linkId: this.linkId,
          userId: this.userId
        })
        .then(response => {
          console.log(response);
          this.message = ''; // 入力欄をクリア

          // 送信したメッセージを追加する代わりに、メッセージ一覧を再取得して更新
          this.fetchMessages();
        })
        .catch(error => {
          console.log(error);
        });
      }
    },

    fetchMessages() {
      axios.get('/message', {
        params: {
          userId: this.userId,
          linkId: this.linkId
        }
      }).then(response => {
        this.chat.message = response.data.messages;
        console.log(this.chat.message);
        this.$nextTick(() => {
          this.scrollToBottom();
        });
      });
    },
    scrollToBottom() {
      const container = this.$refs.messageContainer;
      container.scrollTop = container.scrollHeight;
    },
    
  }
}

</script>
<style>
.chat-word{
  background-color: #ffffff;
  border: 1px solid #d8d2d2;
  text-align: left;
  padding: 10px 10px;
  border-radius: 5px;
  margin:10px 20px;
  width: 50%;

}

.input{
  width: 83%;
  border-radius: 20px;
  margin-right: 3%;
  border: 1px solid #d8d2d2;  
}
::placeholder {
  color: #d8d2d2;
}

.sendbutton{
  width: 10%;
  background-color:black;
  font-family:fantasy;
  color: #fcf9f9;
  padding: 5px 10px;
  border-radius: 5px;
}

.message-container {
  /* position: relative; */
  /* padding-bottom: 3rem; */
  overflow-y: scroll;
  height: 550px;
}

.who-you-talkto{
  width: 100%;
  height: 50px;
  /* position: absolute;
  bottom: 0; */
  background-color:#e5e3e3;
  padding: 9px 30px 9px 0px;
  border-bottom: thin solid #000000;
}

.user-area{
  width: 100%;
  /* position: absolute;
  bottom: 0; */
  background-color:#fcf9f9;
  padding: 9px 30px 9px 0px;
}
.parts{
  text-align:end;
  width: 100%;
  margin: 5px;
}
</style>