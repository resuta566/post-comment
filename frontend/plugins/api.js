import Post from "@/api/postApi";
import Comment from "@/api/commentApi";

export default ({ app }, inject) => {
   // Initialize API factories
   const factories = {
        postApi: Post(app.$axios),
        commentApi: Comment(app.$axios)
   };

   // Inject $api
   inject("api", factories);
};
