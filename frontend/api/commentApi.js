export default axios => ({
    getComments(postId){
        return axios.get(`post-comment/${postId}`);
    },

    postComment(postId, payload){
        return axios.post(`post-comment/${postId}`, payload)
    }

});