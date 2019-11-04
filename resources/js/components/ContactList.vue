<template>
    <div class=" card contacts-list">
        <ul>
            <li v-for="contact in sortedContacts" :key="contact.id"  @click="selectContact(contact)" :class="{ 'selected': contact == selected}" >
                <div class="avatar">
                    <img v-bind:src="'img/profile/'+ contact.photo" width="50px" height="50px" :alt="contact.name">
                </div>
                <div class="contact">
                    <p class="featurette name">{{contact.name}}</p>
                    <p class="email">{{contact.email}}</p>
                </div>
                <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props : {
            contacts: {
                type: Array,
                default: []
            }
        },
        data(){
            return {
                selected: this.contacts.length ? this.contacts[0] : null,
            };
        },
        methods:{
            selectContact(contact){
                this.selected = contact;
                this.$emit('selected',contact)
            }
        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact == this.selected) {
                        return Infinity;
                    }
                    return contact.unread;
                }]).reverse();
            }
        }
    }
</script>
<style lang="scss" scoped>

    .email{
        font-size:14px;
        font-weight: 700;
    }
    .contacts-list {
        flex: 3;
        max-height: 600px;
        overflow: scroll;
        border-left: 1px solid #a6a6a6;

        ul {
            list-style-type: none;
            padding-left: 0;
            li {
                display: flex;
                padding: 2px;
                border-bottom: 1px solid #aaaaaa;
                height: 80px;
                position: relative;
                cursor: pointer;
                &.selected {
                    background: #6cb2eb;
                }
                span.unread {
                    background: #82e0a8;
                    color: #fff;
                    position: absolute;
                    right: 11px;
                    top: 20px;
                    display: flex;
                    font-weight: 700;
                    min-width: 20px;
                    justify-content: center;
                    align-items: center;
                    line-height: 20px;
                    font-size: 12px;
                    padding: 0 4px;
                    border-radius: 50%;
                }
                .avatar {
                    flex: 1;
                    display: flex;
                    align-items: center;
                    img {
                        width: 50px;
                        border-radius: 50%;
                        margin: 0 auto;
                    }
                }
                .contact {
                    flex: 2;
                    font-size: 10px;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    p {
                        margin: 0;
                        &.name {
                            font-size: 18px;
                        }
                    }
                }
            }
        }
    }
</style>
