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
                        <!-- username field -->
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
                        <!-- Comment Field -->
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
        postId: { // get the post id for api call
            type: [Number, String],
            required: true,
            default: 1
        }
    },
    data() { 
        return {
            loading: false, //Card progress animation
            valid: false, //form
            username: '',
            usernameRules: [ // Frontend Validations
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
            return this.$store.getters['comment/reply']; //get the reply details from store
        }
    },
    methods: {
        async submit() {
            setTimeout(() => {
                if(this.$refs.form.validate()){
                    let confirmation = confirm('Do you want to add this comment? ')

                    // Do nothing if user cancel
                    if(!confirmation) {
                        return;
                    }
                    
                    //Show card loading progress bar
                    this.loading = true

                    // Initialize comment object
                    let commentForm = {
                        username: this.username,
                        comment: this.comment,
                        comment_id: this.replyTo ? this.replyTo.commentId : null,
                    }

                    // Comment Post API
                    this.$api.commentApi.postComment(this.postId, commentForm)
                        .then(response => {
                            // check if status Ok
                            if(response.status === 200){
                                // Get the new Comments
                                this.$api.commentApi.getComments(this.postId)
                                    .then(response => {
                                        this.$store.commit('comment/setComments', response.data)
                                        // Just to be sure that will execute after storing new comments
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
                                        this.loading = false; // Stop loading progressbar animation
                                    })
                            }
                        })
                        .catch(err => {
                            console.log(err, 'postComments');
                        })
                        .finally(() => {
                            this.loading = false; // Stop loading progressbar animation
                        })
                }else{
                    this.loading = false // Stop loading progressbar animation
                }
            })
        }
    }
}

</script>

<style>

</style>