<template>
    <div class="mb-4">
        <quill-editor theme="snow" v-model:content="(block.content || {}).text" :read-only="readonly"></quill-editor>
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
            text: '',
        }
    }
}
</script>
