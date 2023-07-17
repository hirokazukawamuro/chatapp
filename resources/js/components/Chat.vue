<template>
  <div class="message-container" ref="messageContainer">
    <div :key="selectedUserName" class="who-you-talkto">
      {{ "＜ " + selectedUserName }}
    </div>
    <div v-for="message in chat.message" :key="message.id" class="message-parent" :class="[isCurrentUser(message.user.id) ? 'align-right' : '']">
      <div class="message-content">
        <span class="sender-name">{{ getMessageSenderName(message.user.id) }}</span>
        <span class="chat-word" >{{ message.message }}</span>
      </div>
    </div>
  </div>
  <div class="user-area">
      <div class="parts">
        <input type="text" name="message" placeholder="Type your message here.." v-model="message" class="input" @keyup.enter="send">
        <!-- @keypress="send"  -->
        <button @click="send" class="sendbutton">
          SEND
        </button>
      </div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'Chat',
  props: {
    linkId: {
      type: [String, Number],
      required: true,
    },
    userId: {
      type: [String, Number],
      required: true,
    },
    selectedUserName: {
      type: String,
      required: true,
    },
    users: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      message: '',
      chat: {
        message: [],
      },
    };
    
  },
  watch: {
    '$route.params': {
      immediate: true, // 初期値も監視対象に含める場合はtrue
      handler(newParams, oldParams) {
        // paramsの変更があった場合に実行される処理
        this.fetchMessages();
        console.log('paramsが変更されました:', newParams, oldParams);
      }
    }
  },
  mounted() {
    window.Echo.private('chat').listen('ChatEvent', (e) => {
      this.chat.message.push(e.message);
      this.fetchMessages();
    });
  },
  methods: {
    isCurrentUser(userId) {
    return userId === this.userId;
  },
    send() {
      if (this.message.length !== 0) {
        axios
          .post('/send', {
            message: this.message,
            linkId: this.linkId,
            userId: this.userId,
          })
          .then((response) => {
            console.log(response);
            this.message = ''; // 入力欄をクリア

            // 送信したメッセージを追加する代わりに、メッセージ一覧を再取得して更新
            this.fetchMessages();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    fetchMessages() {
      axios
        .get('/message', {
          params: {
            userId: this.userId,
            linkId: this.linkId,
          },
        })
        .then((response) => {
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

    getMessageSenderName(userId) {
      const user = this.users.find((user) => user.id === userId);
      return user ? user.name : '';
    },
  },
};
</script>

<style>
.align-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  }

.message-content{
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.sender-name{
  padding-left: 40px;
  margin-right: 20px;
  
  
}
.chat-word {
  background-color: #ffffff;
  border: 1px solid #d8d2d2;
  padding: 10px 10px;
  border-radius: 5px;
  margin: 0 20px 10px 30px;
  /* width: 50%; */
}

.input {
  width: 60%;
  border-radius: 20px;
  margin-right: 2%;
  margin-left: 3%;
  border: 1px solid #d8d2d2;
}
::placeholder {
  color: #d8d2d2;
}

.sendbutton {
  width: 7%;
  background-color: black;
  font-family: fantasy;
  color: #fcf9f9;
  padding: 5px 10px;
  border-radius: 5px;
}

.message-container {
  overflow-y: scroll;
  height:90%;
}

.who-you-talkto {
  width: 100%;
  height: 50px;
  font-size: 25px;
  font-weight: 400;
  background-color: #e5e3e3;
  padding: 9px 30px 15px 0px;
  border-bottom: thin solid #000000;
  position: sticky;
  top:0px;
}

.user-area {
  width:100%;
  background-color: #fcf9f9;
  padding: 5px 30px 9px 0px;
  position: fixed;
  bottom:0;
}

.parts {
  text-align:left;
  width: 100%;
  margin: 5px;
}
</style>
