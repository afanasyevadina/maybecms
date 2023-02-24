<template>
    <div class="p-4">
        <div class="row">
            <div class="col mb-4">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <router-link to="/media/images" class="nav-link active">Images</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/media/video" class="nav-link">Video</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/media/files" class="nav-link">Files</router-link>
                    </li>
                </ul>
            </div>
            <div class="col-auto mb-4">
                <a href="#" data-bs-toggle="modal" data-bs-target="#upload-image" class="btn btn-success">Upload image</a>
            </div>
        </div>
        <div class="text-center" v-if="loading">
            <div class="spinner-grow text-secondary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <template v-else>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-auto mb-4" v-for="image in images.data" :key="image.id">
                            <div class="card">
                                <a href="#" class="card-body" @click.prevent="activeMedia = image">
                                    <img class="preview-img img-fluid border bg-light" :src="image.path" alt="" width="200">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" v-if="activeMedia">
                    <div class="sticky-top card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">File details</h5>
                            <button type="button" class="btn btn-close" @click.prevent="activeMedia = null"></button>
                        </div>
                        <div class="card-body">
                            <img class="preview-img img-fluid mb-3 border bg-light" :src="activeMedia.path" alt="">
                            <div>Original name: {{ activeMedia.original_name }}</div>
                            <div>Size: {{ formatSize(activeMedia.size) }}</div>
                            <div>Uploaded at: {{ activeMedia.created_at }}</div>
                            <div class="text-end">
                                <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-file-${activeMedia.id}`">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <DeleteFile :modal-key="`delete-file-${activeMedia.id}`" @remove="images.data.splice(images.data.findIndex(v => v.id === activeMedia.id), 1)"></DeleteFile>
                </div>
            </div>
            <UploadImage :modal-key="'upload-image'" @upload="upload"></UploadImage>
        </template>
    </div>
</template>

<script>
import DeleteFile from "../../components/media/DeleteFile.vue";
import UploadImage from "../../components/media/UploadImage.vue";
export default {
    name: 'Images',
    components: {
        DeleteFile,
        UploadImage
    },
    data() {
        return {
            images: {
                data: []
            },
            loading: true,
            activeMedia: null
        }
    },
    methods: {
        upload: function (image) {
            this.images.data.unshift(image)
        }
    },
    mounted() {
        this.getJson(`/api/admin/files?type=image`,json => {
                this.images = json
                this.loading = false
            })
    }
}
</script>
