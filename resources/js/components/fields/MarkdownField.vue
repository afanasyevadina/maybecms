<template>
    <div class="mb-4">
        <quill-editor theme="snow" ref="quillEditor" @ready="ready" @textChange="textChange" :read-only="field.source"></quill-editor>
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
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
export default {
    name: "MarkdownField",
    components: {
        QuillEditor
    },
    props: {
        field: {
            type: Object
        }
    },
    data() {
        return {
            text: '',
        }
    },
    computed: {
        sources: function () {
            return (this.postType?.structure?.fields || [])
                .filter(item => item.type === 'markdown')
                .map(item => ({...item, slug: `field.${item.slug}`}))
        }
    },
    methods: {
        ready: function () {
            this.$refs.quillEditor.setHTML(this.field.value || '')
        },
        textChange: function () {
            this.field.value = this.$refs.quillEditor.getHTML()
        }
    }
}
</script>
