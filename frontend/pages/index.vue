<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="8" md="6">
      <v-card
        color="red"
        dark
      >
      <!-- Post Title -->
        <v-card-title>
          <v-icon
            large
            left
          >
            mdi-marker-check
          </v-icon>
          <span class="text-h6 font-weight-light">{{ post.title }}</span>
        </v-card-title>
        <!-- Post Body -->
        <v-card-text class="text-h5 font-weight-bold">
          <p style="color: #e9e9e9;">
            {{ post.body }}
          </p>
        </v-card-text>
        <!-- Avatar Details -->
        <v-card-actions>
          <v-list-item class="grow">
            <v-list-item-avatar color="grey darken-3">
              <v-img
                class="elevation-6"
                alt=""
                src="https://scontent.fceb1-3.fna.fbcdn.net/v/t39.30808-6/246979653_4314970438600873_7740413185430116016_n.jpg?_nc_cat=104&ccb=1-5&_nc_sid=09cbfe&_nc_eui2=AeGW-2_k7wEUi1hp-4F-HFJCSRdk93YtQQFJF2T3di1BAYZc3oD6gRvyrNlWrT6k_FzvEv_qIyV61lR6H2uCgki0&_nc_ohc=OTXtj2rq83YAX9tWWQL&_nc_oc=AQkmgvp7vepa3gncYUTl6zIa-zindRUTywv7pDLGNjoLkbIjqHxSzAWwpLrt7VagpI4&_nc_ht=scontent.fceb1-3.fna&oh=00_AT8OaiYy2R3sZFSAwya0UzGgApdiO8LZJKxGLdjHAfdH2A&oe=623C2ED0"
              ></v-img>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>Jei-Res 
                <time-ago :datetime="new Date(post.created_at + ' UTC')" ></time-ago>
              </v-list-item-title>
            </v-list-item-content>

            <v-row
              align="center"
              justify="end"
            >
              <v-icon class="mr-1">
                mdi-message-reply
              </v-icon>
              <span class="subheading mr-2">{{commentCount}}</span>
              <span class="mr-1">·</span>
              <v-icon class="mr-1">
                mdi-share-variant
              </v-icon>
            </v-row>
          </v-list-item>
        </v-card-actions>
      </v-card>
      <Comments></Comments>
      <AddComment :post-id="post.id"></AddComment>
    </v-col>
  </v-row>
</template>
<script>
import Comments from '@/components/Comments'
import AddComment from '@/components/AddComment'

export default {
  components: {
    Comments,
    AddComment
  },
  async asyncData({app, store}){
    const postResponse = await app.$api.postApi.getPost() // get the post from api
    const commentResponse = await app.$api.commentApi.getComments(postResponse.data.id) // get the comment of the post

    store.commit('comment/setComments', commentResponse.data) //store the comment of the post
    return {
      post: postResponse.data //pass the post data to the component
    }
  },

  computed: {
    // get the comment from state
    comments() {
      return this.$store.getters['comment/comments']
    },
    // This is not working UI aethetics only.
    commentCount() {
      return 10
    },
  }

}
</script>