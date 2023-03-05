<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>Post types</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-model" class="btn btn-success">Create model</a>
            </div>
            <div class="text-center" v-if="!postTypesInitialized">
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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="model in postTypes" :key="model.id">
                        <tr>
                            <td>{{ model.id }}</td>
                            <td>
                                <router-link :to="{name: 'Posts', params: {postType: model.slug}}">{{ model.plural_title }}</router-link>
                            </td>
                            <td class="text-end text-nowrap">
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
                            No models yet
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-model" class="btn btn-outline-dark">Create
                                model</a>
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
    computed: {
        ...mapState([
            'postTypes',
            'postTypesInitialized',
        ])
    }
}
</script>
