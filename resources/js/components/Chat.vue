<template>
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Chat Room</h3>
        </div>
        <div class=" container card-body chat-app">
            <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
            <ContactList :contacts="contacts" @selected="startConversationWith"/>
        </div>
    </div>
</template>

<script>
    import Conversation from "./Conversation";
    import ContactList from "./ContactList";
    export default {
        props:{
            user: {
                type: Object,
                required: true
            }
        },
        data(){
            return {
                selectedContact:null,
                messages:[],
                contacts:[],
            }
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage',(e)=>{
                    this.handleIncoming(e.message);
                })

                axios.get("api/contacts").then((response) => (this.contacts = response.data));

        },
        methods: {
            startConversationWith(contact){
                this.updateUnreadCount(contact, true);
                axios.get(`api/conversation/${contact.id}`)
                    .then((response)=>{
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
            },
            saveNewMessage(message){
                this.messages.push(message);
            },
            handleIncoming(message) {
                if (this.selectedContact && message.from == this.selectedContact.id) {
                    this.saveNewMessage(message);
                    return;
                }
                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(contact, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== contact.id) {
                        return single;
                    }
                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;
                    return single;
                })
            }
        },
        components:{Conversation,ContactList}
    }


</script>
<style lang="scss" scoped>
    .chat-app {
        display: flex;
    }
</style>
