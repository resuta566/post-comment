<template>
  <v-container>
      <v-card>
            <v-card-title v-if="!this.replies.length > 0">
                Comments 
            </v-card-title>
            <div v-else></div>
            <v-card-text>
                <v-row>
                    <!-- {{commentReplies(sortedComments)}} -->
                    <v-col cols="12" v-for="comment in sortedComments" :key="comment.id">
                        <Comment 
                            :username="comment.username"
                            :post-id="comment.post_id"
                            :comment="comment.comment"
                            :comment-date="comment.created_at"
                            :comment-id="comment.id"
                        ></Comment>
                        <div v-if="comment.replies.length > 0 && last == true">
                            <SubComments :replies="commentReplies(comment.replies)" ></SubComments>
                            <!-- {{ commentReplies(comment.replies) }} -->
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
        },
        last: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    computed: {
        comments() {
            if(this.replies.length > 0) {
                return this.replies
            }
            return this.$store.getters['comment/comments']
        },
        sortedComments() { 
            return this.comments.slice()
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at)).flat(2);
        }
    },
    methods: {
        commentReplies(replies) {   
            let flat = [];
            for (let i = 0; i < replies.length; i++) {

                flat.push(replies[i]);
                if(replies[i].replies.length > 0){
                    const childReplies = this.commentReplies(replies[i].replies)
                    // console.log(...childReplies);
                    flat.push(...childReplies);
                    // break;
                }
            }
            return flat;
        }
    }
}
</script>

<style>

</style>