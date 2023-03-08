<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>Модели</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-model" class="btn btn-success" v-if="postTypes.length">Добавить еще одну</a>
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
                        <th>Название</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="model in postTypes" :key="model.id">
                        <tr>
                            <td>{{ model.id }}</td>
                            <td>
                                {{ model.title }}
                            </td>
                            <td class="text-end text-nowrap">
                                <router-link :to="{name: 'Posts', params: {postType: model.slug}}" class="btn btn-light me-2">
                                    <i class="fas fa-list"></i>
                                </router-link>
                                <router-link :to="{name: 'PostType', params: {id: model.id}}" class="btn btn-light me-2">
                                    <i class="fas fa-pen"></i>
                                </router-link>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-model-${model.id}`">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <delete-model :id="model.id"></delete-model>
                    </template>
                    <tr v-if="!postTypes.length">
                        <td colspan="5" class="text-center py-3">
                            Пока нет моделей
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-model" class="btn btn-outline-dark">Создать первую модель</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </div>
        <create-model></create-model>
    </div>
</template>

<script>
import CreatePostType from "./CreatePostType.vue";
import DeletePostType from "./DeletePostType.vue";
import {mapState} from "vuex";

export default {
    name: 'PostTypes',
    components: {
        'create-model': CreatePostType,
        'delete-model': DeletePostType
    },
    data() {
        return {
            postTypes: [],
            loading: true
        }
    },
    mounted() {
        this.getJson(`/api/post-types`, json => {
            this.postTypes = json.data
            this.loading = false
        })
    }
}
</script>
