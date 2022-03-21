<template>
<v-container>
    <v-card :loading="loading">
        <v-card-text>
            <span class="text-subtitle-2">{{replyTo ? replyTo.username : ''}}</span>
            <span class="text-subtitle-2">{{replyTo ? replyTo.comment : ''}}</span>
        </v-card-text>
        <v-card-text>
            <v-form ref="form" v-model="valid" @submit="submit()">
                <v-container>
                    <v-row>
                        <v-col
                            cols="11"
                            class="pr-1 mr-0 pb-0 mb-0"
                        >
                            <v-text-field
                                v-model="username"
                                :rules="usernameRules"
                                v-on:keyup.enter="submit()"
                                class="pb-0"
                                counter
                                outlined
                                label="Username"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="11"
                            class="pr-1 mr-0 pt-0 mt-0"
                        >
                            <v-text-field
                                v-model="comment"
                                :rules="commentRules"
                                v-on:keyup.enter="submit()"
                                counter
                                outlined
                                clearable
                                rows="2"
                                clear-icon="mdi-close-circle"
                                label="Comment"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="1" class="pl-0 ml-0 mt-n3">
                            <v-btn fab text @click="submit">
                                <v-icon x-large>
                                    mdi-send-circle-outline
                                </v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>
    </v-card>
</v-container>
  
</template>

<script>
export default {
    props: {
        postId: {
            type: [Number, String],
            required: true,
            default: 1
        }
    },
    data() { 
        return {
            replyingTo: false,
            loading: false,
            valid: false,
            username: '',
            usernameRules: [
                v => !!v || 'Username is required',
                v => (v && v.length >= 5) || 'Name must be 5 or more than characters',
                v => (v && v.length <= 15) || 'Name must be less than 15 characters',
            ],
            comment: '',
            commentRules: [
                v => !!v || 'Comment is required',
                v => (v && v.length >= 10) || 'Name must be more than 10 characters',
            ],
        }
    },
    computed:{
        replyTo() {
            return this.$store.getters['comment/reply'];
        }
    },
    watch:{
        replyingTo(){
            if(replyTo && !replyTo.isEmpty) return true;
        }
    },
    methods: {
        async submit() {
            setTimeout(() => {
                if(this.$refs.form.validate()){
                    let confirmation = confirm('Do you want to add this comment? ')

                    if(!confirmation) {
                        return;
                    }
                    
                    this.loading = true

                    let commentForm = {
                        username: this.username,
                        comment: this.comment,
                        comment_id: this.replyTo ? this.replyTo.commentId : null,
                    }

                    this.$api.commentApi.postComment(this.postId, commentForm)
                        .then(response => {
                            console.log(response);

                            if(response.status === 200){
                                this.$api.commentApi.getComments(this.postId)
                                    .then(response => {
                                        this.$store.commit('comment/setComments', response.data)
                                        setTimeout(() => {
                                            this.$refs.form.reset();
                                            this.$refs.form.resetValidation();
                                            this.$store.commit('comment/setReply',{});
                                        })
                                    })
                                    .catch(err => {
                                        console.log(err, 'getComments');
                                    })
                                    .finally(() => {
                                        this.loading = false;
                                    })
                            }
                        })
                        .catch(err => {
                            console.log(err, 'postComments');
                        })
                        .finally(() => {
                            this.loading = false;
                        })
                }else{
                    this.loading = false
                }
            })
        }
    }
}

</script>

<style>

</style>