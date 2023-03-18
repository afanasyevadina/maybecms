<template>
    <div class="vh-100 editor-page bg-white" v-if="page.id">
        <div class="px-3 d-flex justify-content-between align-items-center border-bottom">
            <router-link :to="{name: 'Pages'}" class="btn btn-sm btn-light">
                <i class="fas fa-chevron-left"></i>
                Назад
            </router-link>
            <button type="button" class="btn btn-sm btn-success" @click="save()">
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="saving"></span>
                Сохранить
            </button>
        </div>
        <div class="editor-wrapper">
            <div class="editor-tree border-end overflow-auto p-3">
                <tree-item :block="page" :depth="0" :order="0" :count="page.blocks.length"
                           @update="loadPage"></tree-item>
            </div>
            <div class="editor-fields p-3 overflow-auto">
                <template v-if="activeElement">
                    <field :block="activeElement" @save="loadPage"
                           @remove="activeElement = null; loadPage()"></field>
                </template>
                <template v-else>
                    <div class="mb-4">
                        <label>Название страницы</label>
                        <input type="text" class="form-control" v-model="page.title" placeholder="Page title">
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" v-model="page.active">
                            Активная
                        </label>
                    </div>
                    <MetaFields :meta="page.meta"></MetaFields>
                </template>
            </div>
        </div>
    </div>
    <div class="text-center" v-else>
        <div class="spinner-grow text-secondary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
import MetaFields from "../../components/MetaFields.vue";
import {mapState} from "vuex";
import {mapMutations} from "vuex";

export default {
    name: "Page",
    props: ['id'],
    components: {MetaFields},
    data() {
        return {
            page: {},
            saving: false
        }
    },
    computed: {
        ...mapState([
            'activeElement'
        ])
    },
    methods: {
        loadPage: function () {
            this.page = {}
            this.getJson(`/api/pages/${this.id}`, json => this.page = json.data)
        },
        save: function () {
            this.saving = true
            this.postJson(`/api/pages/${this.id}`, this.page, json => {
                this.page = json.data
                this.saving = false
            })
        },
        ...mapMutations([
            'setPostTypes',
            'setPrimitives',
            'setActiveElement',
        ])
    },
    mounted() {
        this.loadPage()
        this.getJson(`/api/post-types`, json => this.setPostTypes(json.data))
        this.getJson(`/api/primitives`, json => this.setPrimitives(json.data))
    }
}
</script>
