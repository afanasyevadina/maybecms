<template>
    <div class="mb-4">
        <template v-if="block.attachment?.file?.id">
            <img :src="block.attachment?.file?.path" alt="" class="img-fluid mb-3 preview-img border bg-light" width="200">
            <div class="btn-group w-100 border">
                <a :href="block.attachment?.file?.path" target="_blank"
                   class="btn btn-light text-start w-100 overflow-hidden">{{ block.attachment?.file?.original_name }}</a>
                <button type="button" class="btn btn-light" @click.prevent="block.attachment = null">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </template>
        <template v-else>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#choose-image-${block.id}`">
                Выберите изображение
            </button>
            <ChooseImage :modal-key="`choose-image-${block.id}`" @choose="chooseImage"></ChooseImage>
        </template>
    </div>
</template>

<script>
import ChooseImage from "../media/ChooseImage.vue";
export default {
    name: "ImageField",
    props: {
        block: {
            type: Object
        }
    },
    components: { ChooseImage },
    methods: {
        chooseImage: function (file) {
            (this.block.attachment = this.block.attachment || {}).file = file
            this.hideModal()
        }
    }
}
</script>
