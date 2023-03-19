<template>
    <div>
        <div class="mb-4">
            <label>Название блока</label>
            <input type="text" v-model="block.title" required class="form-control">
        </div>
        <template v-for="field in block.content">
            <label>{{ field.title }}</label>
            <component :is="`${field.field_type}-field`" :field="field" :post-type="block.postType"></component>
        </template>
        <div class="mb-4" v-if="block.type === 'section'">
            <label>Источник</label>
            <select v-model="block.post_type_id" class="form-control">
                <option :value="null">-</option>
                <option :value="postType.id" v-for="postType in postTypes" :key="postType.id">{{ postType.title }}</option>
            </select>
        </div>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "BaseField",
    props: {
        block: {
            type: Object
        }
    },
    computed: {
        ...mapState([
            'postTypes'
        ])
    },
    methods: {
        loadPostType: function () {
            if (this.block.post_type_id) {
                this.getJson(`/api/post-types/${this.block.post_type_id}`, json => this.setBlockPostType(this.block.blocks || [], json.data))
            } else {
                this.postType = null
            }
        },
        setBlockPostType: function (blocks, postType) {
            blocks.forEach(block => {
                block.postType = postType
                this.setBlockPostType(block.blocks || [], postType)
            })
        }
    },
    watch: {
        block: {
            deep: true,
            handler: function () {
                this.loadPostType()
            }
        }
    },
    mounted() {
        this.loadPostType()
    }
}
</script>
