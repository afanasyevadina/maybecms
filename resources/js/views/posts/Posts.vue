<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>{{ model.plural_title }}</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-post" class="btn btn-success" v-if="posts.data.length">Добавить еще запись</a>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <template v-else>
                <table class="table table-striped mb-4">
                    <tbody v-if="!posts.data.length">
                    <tr>
                        <td colspan="5" class="text-center py-3">
                            Пока нет ни одной записи
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-post" class="btn btn-outline-dark">Создать первую запись</a>
                        </td>
                    </tr>
                    </tbody>
                    <template v-else>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Автор</th>
                            <th>Последнее обновление</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="post in posts.data" :key="post.id">
                            <tr>
                                <td>{{ post.id }}</td>
                                <td>{{ post.title }}</td>
                                <td>{{ post.user.name }}</td>
                                <td>{{ formatDate(post.updated_at) }}</td>
                                <td class="text-end text-nowrap">
                                    <router-link :to="{name: 'Post', params: {postType: postType, id: post.id}}" class="btn btn-light me-2">
                                        <i class="fas fa-pen"></i>
                                    </router-link>
                                    <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-post-${post.id}`">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <DeletePost :id="post.id"></DeletePost>
                        </template>
                        </tbody>
                    </template>
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
            postTypes: [],
            loading: true
        }
    },
    computed: {
        model: function () {
            return this.postTypes.find(v => v.slug === this.postType) || {}
        }
    },
    mounted() {
        this.getJson(`/api/post-types`, json => this.postTypes = json.data)
        this.getJson(`/api/posts/${this.postType}`, json => {
            this.posts = json
            this.loading = false
        })
    }
}
</script>
