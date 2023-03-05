<template>
    <div>
        <template v-if="block.attachment">
            <video :src="block.attachment?.path" alt="" class="img-fluid mb-3" controls preload="auto" width="300"></video>
            <div class="btn-group w-100 border">
                <a :href="block.attachment?.path" target="_blank"
                   class="btn btn-light text-start w-100">{{ block.attachment?.original_name }}</a>
                <button type="button" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-${block.attachment.id}`">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="modal fade" tabindex="-1" :id="`delete-${block.attachment.id}`">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="#" @submit.prevent="remove" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>This attachment will be deleted.</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
        <template v-else>
            <template v-if="filePreview">
                <video :src="filePreviewContent" alt="" class="img-fluid mb-3" controls preload="auto" width="300"></video>
                <div class="btn-group w-100 border">
                    <div class="w-100 d-flex align-items-center px-3">{{ filePreview.name }}</div>
                    <button type="button" class="btn btn-light" @click.prevent="filePreview = null">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-success" @click.prevent="upload">
                        Upload
                    </button>
                </div>
            </template>
            <input type="file" class="form-control" accept="video/*" @change="preview" :readonly="readonly" v-else>
        </template>
    </div>
</template>

<script>
export default {
    name: "Video",
    props: {
        block: {
            type: Object
        },
        readonly: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            uploadState: {
                loading: false,
                progress: 0
            },
            filePreview: null,
            filePreviewContent: null
        }
    },
    methods: {
        startProgress: function() {
            this.uploadState = {
                loading: true,
                progress: 0
            }
        },
        resetProgress: function() {
            this.uploadState = {
                loading: false,
                progress: 0
            }
            this.filePreview = null
            this.filePreviewContent = null
        },
        preview: function (event) {
            this.filePreview = null
            if (event.target.files && event.target.files[0]) {
                this.filePreview = event.target.files[0]
                let reader = new FileReader()
                reader.onload = e => this.filePreviewContent = e.target.result
                reader.readAsDataURL(event.target.files[0])
            }
        },
        upload: function () {
            if (this.filePreview) {
                this.startProgress()
                let request = new XMLHttpRequest()
                let formData = new FormData()
                formData.append('file', this.filePreview)
                if(this.block.attachment?.id) {
                    request.open('POST', `/api/attachments/${this.block.attachment?.id}`)
                } else {
                    request.open('POST', `/api/attachments`)
                    formData.append('type', 'file')
                    formData.append('attachable_id', this.block.id)
                    formData.append('attachable_type', this.block.class_name)
                }
                request.setRequestHeader('Authorization', `Bearer ${this.$store.getters.apiToken}`)
                request.responseType = 'json'
                request.send(formData)
                request.onload = () => {
                    this.block.attachment = request.response.data
                    this.resetProgress()
                }
            }
        },
        remove: function () {
            this.deleteRequest(`/api/attachments/${this.block.attachment?.id}`,() => {
                    this.block.attachment = null
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove())
                })
        }
    }
}
</script>
