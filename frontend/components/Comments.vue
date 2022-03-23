<template>
  <v-container>
      <v-card>
            <v-card-title v-show="!this.replies.length > 0">
                Comments 
            </v-card-title>
            <v-card-text>
                <v-row>
                    <!-- Comment Loop -->
                    <v-col cols="12" v-for="comment in sortedComments" :key="comment.id">
                        <Comment 
                            :username="comment.username"
                            :post-id="comment.post_id"
                            :comment="comment.comment"
                            :comment-date="comment.created_at"
                            :comment-id="comment.id"
                            @reply="reply(comment)"
                        ></Comment>
                        <!-- If comment has replies then show - Recursive component -->
                        <div v-if="comment.replies.length > 0">
                            <SubComments :replies="comment.replies" :last="true"></SubComments>
                        </div>
                        <div v-else></div>
                    </v-col>
                </v-row>
            </v-card-text>
      </v-card>
  </v-container>
</template>

<script>
import Comment from '@/components/Comment'
import SubComments from '@/components/SubComments'
import Comments from '@/components/Comments'
export default {
    component: {
        Comment,
        SubComments,
        Comments
    },
    props: {
        replies: { 
            type: [Object, Array],
            required: false,
            default() {
                return {}
            }
        }
    },
    computed: {
        // check comment if reply or parent comment
        comments() {
            if(this.replies.length > 0) {
                return this.replies
            }
            return this.$store.getters['comment/comments']
        },
        // Sort to newest first
        sortedComments() { 
            return this.comments.slice()
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at)).flat(2);
        }
    }
}
</script>

<style>

</style>