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
                            <router-link to="/media/video" class="nav-link">Video</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/media/files" class="nav-link active">Files</router-link>
                        </li>
                    </ul>
                </div>
                <div class="col-auto mb-4">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#upload-file" class="btn btn-success">Upload file</a>
                </div>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <template v-else>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4" v-for="(file, fileIndex) in files.data" :key="file.id">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <a :href="file.path">{{ substrWithDots(file.original_name) }}</a>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-file-${file.id}`">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                            <DeleteFile :modal-key="`delete-file-${file.id}`" @remove="files.data.splice(fileIndex, 1)"></DeleteFile>
                        </div>
                    </div>
                </div>
                <UploadFile :modal-key="'upload-file'" @upload="upload"></UploadFile>
            </template>
        </div>
    </div>
</template>

<script>
import DeleteFile from "../../components/media/DeleteFile.vue";
import UploadFile from "../../components/media/UploadFile.vue";
export default {
    name: 'Files',
    components: {
        DeleteFile,
        UploadFile
    },
    data() {
        return {
            files: {
                data: []
            },
            loading: true
        }
    },
    methods: {
        upload: function (file) {
            this.files.data.unshift(file)
        }
    },
    mounted() {
        this.getJson(`/api/admin/files?type=file`,json => {
                this.files = json
                this.loading = false
            })
    }
}
</script>
