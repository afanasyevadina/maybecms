<template>
    <div>
        <div class="mb-4">
            <label>Название блока</label>
            <input type="text" v-model="block.title" required class="form-control">
        </div>
        <div class="row">
            <template v-for="field in block.content">
                <div :class="field.w">
                    <label>{{ field.title }}</label>
                    <component :is="`${field.field_type}-field`" :field="field" :post-type="field.allow_source ? block.postType : null"></component>
                </div>
            </template>
        </div>
        <div class="mb-4" v-if="block.component?.id">
            <label class="d-block">Компонент</label>
            <router-link :to="{name: 'Component', params: {id: block.component.id}}" class="btn btn-light" target="_blank">
                {{ block.component?.title }}
                <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i>
            </router-link>
        </div>
        <template v-if="block.allow_source">
            <label>Источник</label>
            <div class="mb-4" v-if="block.postType?.id">
                <router-link :to="{name: 'Posts', params: {postType: block.postType?.slug}}" class="btn btn-light" target="_blank">
                    {{ block.postType?.title }}
                    <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i>
                </router-link>
                <UnsetPostTypeModal :block="block" v-if="block.query" @update="$emit('update')"></UnsetPostTypeModal>
            </div>
            <div class="mb-4" v-else>
                <SetPostTypeModal :block="block" @update="$emit('update')"></SetPostTypeModal>
            </div>
        </template>
    </div>
</template>

<script>
import {mapState} from "vuex";
import SetPostTypeModal from "./SetPostTypeModal.vue";
import UnsetPostTypeModal from "./UnsetPostTypeModal.vue";

export default {
    name: "BaseField",
    components: {SetPostTypeModal, UnsetPostTypeModal},
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
}
</script>
