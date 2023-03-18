import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
    state () {
        return {
            user: null,
            activeElement: null,
            postTypes: [],
            primitives: [],
            fieldTypes: [],
            relationTypes: []
        }
    },
    getters: {
        apiToken (state) {
            return state.user?.token
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
        setActiveElement (state, element) {
            state.activeElement = element
        },
        setPostTypes (state, postTypes) {
            state.postTypes = postTypes
        },
        setPrimitives (state, primitives) {
            state.primitives = primitives
        },
        setFieldTypes (state, fieldTypes) {
            state.fieldTypes = fieldTypes
        },
        setRelationTypes (state, relationTypes) {
            state.relationTypes = relationTypes
        }
    }
})

export default store
