<template>
    <div class="p-4">
        <div>
            <div class="row">
                <div class="col mb-4">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <router-link to="/media/images" class="nav-link">Images</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/media/video" class="nav-link active">Video</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/media/files" class="nav-link">Files</router-link>
                        </li>
                    </ul>
                </div>
                <div class="col-auto mb-4">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#upload-video" class="btn btn-success">Upload video</a>
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
                            <div class="col-auto mb-4" v-for="video in videos.data" :key="video.id">
                                <div class="card">
                                    <a href="#" class="card-body" @click.prevent="activeMedia = video">
                                        <video class="preview-img img-fluid border bg-light" :src="video.path" width="200"></video>
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
                                <video class="preview-img img-fluid mb-3 border bg-light" :src="activeMedia.path" controls></video>
                                <div>Size: {{ formatSize(activeMedia.size) }}</div>
                                <div>Uploaded at: {{ activeMedia.created_at }}</div>
                                <div class="text-end">
                                    <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-file-${activeMedia.id}`">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <DeleteFile :modal-key="`delete-file-${activeMedia.id}`" @remove="videos.data.splice(videos.data.findIndex(v => v.id === activeMedia.id), 1)"></DeleteFile>
                    </div>
                </div>
                <UploadVideo :modal-key="'upload-video'" @upload="upload"></UploadVideo>
            </template>
        </div>
    </div>
</template>

<script>
import DeleteFile from "../../components/media/DeleteFile.vue";
import UploadVideo from "../../components/media/UploadVideo.vue";
export default {
    name: 'Video',
    components: {
        DeleteFile,
        UploadVideo
    },
    data() {
        return {
            videos: {
                data: []
            },
            loading: true,
            activeMedia: null
        }
    },
    methods: {
        upload: function (video) {
            this.videos.data.unshift(video)
        }
    },
    mounted() {
        this.getJson(`/api/admin/files?type=video`,json => {
                this.videos = json
                this.loading = false
            })
    }
}
</script>
