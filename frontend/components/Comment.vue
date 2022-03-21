<template>
  <v-row>
      <v-col cols="12">
          <v-card outline>
                <v-card-text>
                    <ul><span class="text-caption">{{username}}</span></ul>
                    <ul><span class="text-body-1">{{comment}}</span></ul>
                </v-card-text>
                <v-card-actions>
                    <ul>
                        <v-btn
                        color="red lighten-2"
                        text
                        @click="reply"
                    >
                        Reply
                    </v-btn>
                    <!-- Time Ago ex 4h, just now etc... -->
                    <time-ago :datetime="new Date(commentDate + ' UTC')"></time-ago> 
                    </ul>
                </v-card-actions>
          </v-card>
      </v-col>
  </v-row>
</template>

<script>
export default {
    props: {
        commentId: {
            type: [String, Number],
            require: true,
            default: null
        },
        username: {
            type: String,
            require: true,
            default: 'username'
        },
        postId: {
            type: Number,
            require: true,
            default: 1
        },
        comment: {
            type: String,
            require: true,
            default: 'Comment'
        },
        commentDate: {
            type: [String, Number],
            require: true,
            default: new Date()
        }
    },
    methods: {
        reply(){
            // if call then store this values to the state to be used for replying or adding comment
            this.$store.commit('comment/setReply',
                { 
                    commentId: this.commentId, 
                    username: 'Replying To: ' + this.username, 
                    comment: ' - ' + this.comment, 
                    postId:this.postId 
                });
            // Smooth scrolling to the comment form
            setTimeout(()=>{
                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
            })
        }
    }
}
</script>

<style>

</style>