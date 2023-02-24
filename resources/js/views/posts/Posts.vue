<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>{{ model.plural_title }}</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-post" class="btn btn-success">Create {{ (model.title || '').toLowerCase() }}</a>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <template v-else>
                <table class="table table-striped mb-4">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Last update</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="post in posts.data" :key="post.id">
                        <tr>
                            <td>{{ post.id }}</td>
                            <td>{{ post.title }}</td>
                            <td>{{ post.updated_at }}</td>
                            <td class="text-end text-nowrap">
                                <router-link :to="`/${postType}/${post.id}`" class="btn btn-light me-2">
                                    <i class="fas fa-pen"></i>
                                </router-link>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-post-${post.id}`">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <DeletePost :id="post.id"></DeletePost>
                    </template>
                    <tr v-if="!posts.data.length">
                        <td colspan="5" class="text-center py-3">
                            No {{ (model.plural_title || '').toLowerCase() }} yet
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-post" class="btn btn-outline-dark">Create
                                {{ (model.title || '').toLowerCase() }}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </div>
        <CreatePost :postType="postType"></CreatePost>
    </div>
</template>

<script>
import CreatePost from "./CreatePost.vue";
import DeletePost from "./DeletePost.vue";

export default {
    name: 'Posts',
    props: ['postType'],
    components: {
        CreatePost,
        DeletePost
    },
    data() {
        return {
            posts: {
                data: []
            },
            loading: true
        }
    },
    computed: {
        model: function () {
            return this.$root.$data.postTypes.find(v => v.plural_slug === this.postType || v.slug === this.postType) || {}
        }
    },
    mounted() {
        this.getJson(`/api/admin/${this.postType}`, json => {
            this.posts = json
            this.loading = false
        })
    }
}
</script>
