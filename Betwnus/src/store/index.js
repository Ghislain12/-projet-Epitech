/* eslint-disable prettier/prettier */
import { createStore } from "vuex";

export default createStore({
    state: {
        posts: [],
    },
    mutations: {
        setPosts(state, posts) {
            state.posts = posts;
        },
    },
    actions: {
        fetchAllposts(context) {
            return fetch("http://localhost:8005/wp-json/wp/v2/posts")
                .then((response) => response.json())
                .then((data) => {
                    context.commit("setPosts", data);
                    // console.log(data)
                })
                .catch((err) => console.log(err));
        },
    },
    getters: {
        posts(state) {
            return state.posts;
        },
    },
    modules: {},
});