<template>
    <div class="mb-4">
        <div class="mb-4">
            <input type="text" v-model="(block.content || {}).text" class="form-control" :readonly="readonly" placeholder="Текст ссылки">
        </div>
        <div class="mb-4">
            <input type="url" v-model="(block.content || {}).link" class="form-control" :readonly="readonly" placeholder="Link URL">
        </div>
        <template v-if="block.attachment">
            <img :src="block.attachment?.path" alt="" class="img-fluid mb-3" width="100">
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
                            <h5 class="modal-title">Подтверждение</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Сейчас удалим иконку</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger">Да, удалите</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Не надо</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
        <template v-else-if="filePreview">
            <img :src="filePreviewContent" alt="" class="img-fluid mb-3" width="100">
            <div class="btn-group w-100 border">
                <div class="w-100 d-flex align-items-center px-3">{{ filePreview.name }}</div>
                <button type="button" class="btn btn-light" @click.prevent="filePreview = null">
                    <i class="fas fa-trash"></i>
                </button>
                <button type="button" class="btn btn-success" @click.prevent="upload">
                    Загрузить
                </button>
            </div>
        </template>
        <template v-else>
            <input type="file" :id="`link-icon-${block.id}`" class="d-none" accept="image/svg+xml" @change="preview" :readonly="readonly">
            <label :for="`link-icon-${block.id}`" class="btn btn-light">
                <i class="fas fa-image"></i>
                Добавить иконку
            </label>
        </template>
    </div>
</template>

<script>
export default {
    name: "LinkField",
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
            this.addIcon = false
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
            this.deleteRequest(`/api/attachments/${this.block.attachment?.id}`, () => {
                    this.block.attachment = null
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove())
                })
        }
    }
}
</script>
