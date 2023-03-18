<template>
    <div>
        <div class="mb-4">
            <label>Название блока</label>
            <input type="text" v-model="block.title" required class="form-control">
        </div>
        <component v-if="!isSection" :is="`${block.type}-field`" :block="block"></component>
        <div class="mb-4">
            <label>Класс CSS</label>
            <input type="text" v-model="(block.content || {}).class" class="form-control">
        </div>
        <div class="mb-4">
            <a href="#" class="btn btn-light" @click.prevent="showSource = true" v-if="!showSource">
                <i class="fas fa-plus"></i> Добавить источник
            </a>
            <template v-else>
                <label>Модель</label>
                <select v-model="block.post_type_id" class="form-control">
                    <option :value="null">-</option>
                    <option :value="postType.id" v-for="postType in postTypes" :key="postType.id">{{ postType.title }}</option>
                </select>
            </template>
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
        isSection: function () {
            return this.block.type === 'section' || !this.block.type
        },
        ...mapState([
            'postTypes'
        ])
    },
    data() {
        return {
            showSource: false,
            postType: null
        }
    },
    methods: {
        loadPostType: function () {
            if (this.block.post_type_id) {
                this.getJson(`/api/post-types/${this.block.post_type_id}`, json => this.postType = json.data)
            } else {
                this.postType = null
            }
        },
        updatePostType: function () {
            this.showSource = Boolean(this.block.post_type_id)
            this.loadPostType()
            this.setBlockPostType(this.block.blocks || [], this.block.post_type_id)
        },
        setBlockPostType: function (blocks, postTypeId) {
            blocks.forEach(block => {
                block.post_type_id = postTypeId
                this.setBlockPostType(block.blocks || [])
            })
        }
    },
    watch: {
        block: {
            deep: true,
            handler: function () {
                this.updatePostType()
            }
        }
    },
    mounted() {
        this.updatePostType()
    }
}
</script>
