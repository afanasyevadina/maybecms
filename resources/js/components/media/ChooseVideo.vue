<template>
    <div class="modal fade" :id="modalKey" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-xxl-down modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="$emit('choose', activeMedia)">
                <div class="modal-header">
                    <h5 class="modal-title">Choose video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Title</h5>
                                        <button type="button" class="btn btn-close" @click.prevent="activeMedia = null"></button>
                                    </div>
                                    <div class="card-body">
                                        <video class="preview-img img-fluid mb-3 border bg-light" :src="activeMedia.path" controls></video>
                                        <div>Size: {{ formatSize(activeMedia.size) }}</div>
                                        <div>Uploaded at: {{ activeMedia.created_at }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" :disabled="!activeMedia">Choose</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ChooseVideo',
    props: ['modalKey'],
    data() {
        return {
            videos: {
                data: []
            },
            loading: true,
            activeMedia: null
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
