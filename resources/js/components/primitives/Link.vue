<template>
    <a :href="block.content?.link" :class="block.content?.class">
        <img :src="block.attachment?.path" alt="" v-if="block.attachment">
        {{ block.content?.text || block.title }}
    </a>
</template>

<script>
export default {
    name: "Link",
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
                    request.open('POST', `/api/admin/attachments/${this.block.attachment?.id}`)
                } else {
                    request.open('POST', `/api/admin/attachments`)
                    formData.append('type', 'file')
                    formData.append('attachable_id', this.block.id)
                    formData.append('attachable_type', this.block.class_name)
                }
                request.setRequestHeader('Authorization', `Bearer ${this.$root.$data.user.token}`)
                request.responseType = 'json'
                request.send(formData)
                request.onload = () => {
                    this.block.attachment = request.response.data
                    this.resetProgress()
                }
            }
        },
        remove: function () {
            this.deleteRequest(`/api/admin/attachments/${this.block.attachment?.id}`, () => {
                    this.block.attachment = null
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove())
                })
        }
    }
}
</script>
