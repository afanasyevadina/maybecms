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
        <div class="mb-4" v-if="!sourceModel">
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
        },
        sourceModel: {
            type: Object,
            default: null
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
            showSource: false
        }
    },
    watch: {
        block: {
            deep: true,
            handler: function () {
                this.showSource = Boolean(this.block.post_type_id)
            }
        }
    },
    mounted() {
        this.showSource = Boolean(this.block.post_type_id)
    }
}
</script>
