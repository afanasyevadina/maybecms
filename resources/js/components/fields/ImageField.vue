<template>
    <div class="mb-4">
        <template v-if="field.attachment?.file?.id">
            <img :src="field.attachment?.file?.path" alt="" class="img-fluid mb-3 preview-img border bg-light" width="200">
            <div class="btn-group w-100 border">
                <a :href="field.attachment?.file?.path" target="_blank"
                   class="btn btn-light text-start w-100 overflow-hidden">{{ field.attachment?.file?.original_name }}</a>
                <button type="button" class="btn btn-light" @click.prevent="field.attachment = null">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </template>
        <template v-else>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#choose-image-${field.id}`" :disabled="field.source">
                Выберите изображение
            </button>
            <ChooseImage :modal-key="`choose-image-${field.id}`" @choose="chooseImage"></ChooseImage>
        </template>
    </div>
    <div class="mb-4" v-if="sources.length">
        <label>Источник</label>
        <select v-model="field.source" class="form-control">
            <option :value="null">-</option>
            <option :value="sourceItem.slug" v-for="sourceItem in sources" :key="sourceItem.slug">{{ sourceItem.title }}</option>
        </select>
    </div>
</template>

<script>
import ChooseImage from "../media/ChooseImage.vue";
export default {
    name: "ImageField",
    props: {
        field: {
            type: Object
        },
        postType: {
            type: Object,
            default: null
        }
    },
    components: { ChooseImage },
    computed: {
        sources: function () {
            return (this.postType?.structure?.fields || [])
                .filter(item => item.type === 'image')
                .map(item => ({...item, slug: `field.${item.slug}`}))
        }
    },
    methods: {
        chooseImage: function (file) {
            (this.field.attachment = this.field.attachment || {}).file = file
            this.hideModal()
        }
    }
}
</script>
