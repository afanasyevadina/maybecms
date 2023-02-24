<template>
    <div class="mb-4">
        <template v-if="block.attachment?.file?.id">
            <div class="row">
                <div class="col-sm-6">
                    <video :src="block.attachment?.file?.path" :poster="block.attachment?.poster?.file?.path" class="img-fluid mb-3 preview-img border bg-light d-block" width="200"></video>
                    <div class="btn-group w-100 border">
                        <a :href="block.attachment?.file?.path" target="_blank"
                           class="btn btn-light text-start w-100 overflow-hidden">{{ block.attachment?.file?.original_name }}</a>
                        <button type="button" class="btn btn-light" @click.prevent="block.attachment = null">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <template v-if="block.attachment?.poster?.file?.id">
                        <img :src="block.attachment?.poster?.file?.path" alt="" class="img-fluid mb-3 preview-img border bg-light d-block" width="200">
                        <div class="btn-group w-100 border">
                            <a :href="block.attachment?.poster?.file?.path" target="_blank"
                               class="btn btn-light text-start w-100 overflow-hidden">{{ block.attachment?.poster?.file?.original_name }}</a>
                            <button type="button" class="btn btn-light" @click.prevent="block.attachment.poster = null">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </template>
                    <template v-else>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#choose-image-${block.id}`">
                            Choose poster
                        </button>
                        <ChooseImage :modal-key="`choose-image-${block.id}`" @choose="choosePoster"></ChooseImage>
                    </template>
                </div>
            </div>
        </template>
        <template v-else>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#choose-video-${block.id}`">
                Choose video
            </button>
            <ChooseVideo :modal-key="`choose-video-${block.id}`" @choose="chooseVideo"></ChooseVideo>
        </template>
    </div>
</template>

<script>
import ChooseVideo from "../media/ChooseVideo.vue";
import ChooseImage from "../media/ChooseImage.vue";
export default {
    name: "ImageField",
    props: {
        block: {
            type: Object
        }
    },
    components: { ChooseVideo, ChooseImage },
    methods: {
        chooseVideo: function (file) {
            (this.block.attachment = this.block.attachment || {}).file = file
            this.hideModal()
        },
        choosePoster: function (file) {
            this.block.attachment = this.block.attachment || {}
            this.block.attachment.poster = this.block.attachment?.poster || {}
            this.block.attachment.poster.file = file
            this.hideModal()
        }
    }
}
</script>
