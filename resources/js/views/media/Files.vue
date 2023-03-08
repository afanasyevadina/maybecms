<template>
    <div class="p-4">
        <div>
            <div class="row">
                <div class="col mb-4">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <router-link :to="{name: 'Images'}" class="nav-link">Изображения</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Video'}" class="nav-link">Видео</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Files'}" class="nav-link active">Файлы</router-link>
                        </li>
                    </ul>
                </div>
                <div class="col-auto mb-4" v-if="files.data.length">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#upload-file" class="btn btn-success">Загрузить файл</a>
                </div>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <template v-else-if="files.data.length">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4" v-for="(file, fileIndex) in files.data" :key="file.id">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <a :href="file.path">{{ substrWithDots(file.original_name) }}</a>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-file-${file.id}`">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                            <DeleteFile :modal-key="`delete-file-${file.id}`" :id="file.id" @remove="files.data.splice(fileIndex, 1)"></DeleteFile>
                        </div>
                    </div>
                </div>
            </template>
            <table class="table table-striped" v-else>
                <tbody>
                <tr>
                    <td class="text-center py-3">
                        Пока нет файлов
                        <br>
                        <br>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#upload-file" class="btn btn-outline-dark">Загрузить первый файл</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <UploadFile :modal-key="'upload-file'" @upload="upload"></UploadFile>
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
        this.getJson(`/api/files?type=file`,json => {
                this.files = json
                this.loading = false
            })
    }
}
</script>
