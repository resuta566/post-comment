export const state = () => ({
    comments: null,
    reply: null,
})

export const getters = {
    comments: (state) => { 
        return state.comments
    },
    reply: (state) => { 
        return state.reply
    }
}

export const mutations = {
    setComments: (state, val) => {
        state.comments = JSON.parse(JSON.stringify(val)) ;
    },
    setReply: (state, val) => {
        state.reply = JSON.parse(JSON.stringify(val)) ;
    },
    // addComment: (state, comment) => {
    //     state.comments.push(comment)
    // }
}