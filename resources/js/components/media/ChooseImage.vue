<template>
    <div class="modal fade" :id="modalKey" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-xxl-down modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="$emit('choose', activeMedia)">
                <div class="modal-header">
                    <h5 class="modal-title">Choose image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="text-center" v-if="loading">
                        <div class="spinner-grow text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <template v-else>
                        <div class="row m-0 h-100">
                            <div class="col py-3 bg-light">
                                <div class="row">
                                    <div class="col-auto mb-4" v-for="image in images.data" :key="image.id">
                                        <div class="card position-relative">
                                            <label class="card-body c-pointer" @click.prevent="activeMedia = image">
                                                <img class="preview-img img-fluid border bg-light" :src="image.path" alt="" width="200">
                                            </label>
                                            <div class="text-end position-absolute w-100">
                                                <input type="checkbox" :checked="activeMedia?.id === image.id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 bg-white border-start" v-if="activeMedia">
                                <div class="sticky-top py-3">
                                    <img class="preview-img img-fluid mb-3 border bg-light" :src="activeMedia.path" alt="">
                                    <div>Original name: {{ activeMedia.original_name }}</div>
                                    <div>Size: {{ formatSize(activeMedia.size) }}</div>
                                    <div>Uploaded at: {{ formatDate(activeMedia.created_at) }}</div>
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
    name: 'ChooseImage',
    props: ['modalKey'],
    data() {
        return {
            images: {
                data: []
            },
            loading: true,
            activeMedia: null
        }
    },
    mounted() {
        this.getJson(`/api/files?type=image`,json => {
                this.images = json
                this.loading = false
            })
    }
}
</script>
