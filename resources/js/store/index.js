import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
    state () {
        return {
            user: null,
            postTypes: [],
            postTypesInitialized: false
        }
    },
    getters: {
        apiToken (state) {
            return state.user?.token
        },
        getPostTypeBySlug: (state) => (slug) => {
            return state.postTypes.find(v => v.slug === slug) || {}
        }
    },
    mutations: {
        setUser (state, user) {
            state.user = user
        },
        unsetUser (state) {
            state.user = null
            localStorage.removeItem('_cms_user')
        },
        setPostTypes (state, postTypes) {
            state.postTypes = postTypes
            state.postTypesInitialized = true
        }
    }
})

export default store
