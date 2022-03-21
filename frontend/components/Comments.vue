<template>
  <v-container>
      <v-card>
            <v-card-title v-show="!this.replies.length > 0">
                Comments 
            </v-card-title>
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
                            @reply="reply(comment)"
                        ></Comment>
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
        comments() {
            if(this.replies.length > 0) {
                return this.replies
            }
            return this.$store.getters['comment/comments']
        },
        sortedComments() { 
            return this.comments.slice()
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at)).flat(2);
        },
        // commentReplies(replies) {
        //     // console.log(replies, 'Bobo');
        //     if(replies.length === 0) return;

        //     let flatten = [];
        //     for(let i= 0; replies.length <= i; i++){
        //         // flatten.push(replies[i]);
        //         console.log(replies[i]);

        //         if(replies[i].replies.length === 0) break;

        //         const child = this.commentReplies(replies[i].replies);
        //         if(child.length === 0) return;
        //         flatten.push(...child);
        //         console.log(child, 'child');
                
        //     }
        //     return flatten;
        // }
    },
    methods: {
        reply(comment){
            console.log(comment);
        }
    }
}
</script>

<style>

</style>