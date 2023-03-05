<template>
    <div class="p-4" v-if="post.id">
        <div class="row align-items-end">
            <div class="col mb-4">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab"
                           href="#tab-general">General</a>
                    </li>
                    <li class="nav-item" v-if="post.relations.length || post.inverse_relations?.length">
                        <a class="nav-link" data-bs-toggle="tab"
                           href="#tab-relations">Relations</a>
                    </li>
                </ul>
            </div>
            <div class="col-auto mb-4">
                <button type="button" class="btn btn-success w-100" @click="save()">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="saving"></span>
                    Save
                </button>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-general">
                <div class="border p-4 bg-white mb-5">
                    <input type="text" class="form-control form-control-lg mb-4" v-model="post.title"
                           :placeholder="`${post.postType?.title} title`">
                    <textarea rows="3" v-model="post.description" class="form-control mb-4"
                              :placeholder="`${post.postType?.title} description`"></textarea>
                    <label>
                        <input type="checkbox" v-model="post.active">
                        Active
                    </label>
                </div>
                <template v-if="post.fields.length">
                    <h4 class="mb-3">{{ post.postType?.title }} fields</h4>
                    <div class="border p-4 pb-2 bg-white mb-5">
                        <div class="border p-4 mb-4" v-for="field in post.fields" :key="field.slug">
                            <div class="mb-2">{{ field.title }}</div>
                            <component :is="`${field.type}-field`" :block="field"></component>
                        </div>
                    </div>
                </template>
            </div>
            <div class="tab-pane fade" id="tab-relations"
                 v-if="post.relations.length || post.inverse_relations?.length">
                <template v-if="post.relations.length">
                    <h4 class="mb-3">{{ post.postType?.title }} relations</h4>
                    <div class="border p-4 pb-2 bg-white mb-5">
                        <component v-for="relation in post.relations" :key="relation.id" :model="post"
                                   :relation="relation"
                                   :is="relation.type"></component>
                    </div>
                </template>
                <template v-if="post.inverse_relations?.length">
                    <h4 class="mb-3">Used in relations</h4>
                    <div class="border p-4 pb-2 bg-white mb-5" v-for="relation in post.inverse_relations"
                         :key="relation.id">
                        <div class="mb-2">Post type: {{ relation.model?.title }}</div>
                        <div class="mb-2">Relation name: {{ relation.title }}</div>
                        <div class="mb-3">Relation type: {{ relation.type }}</div>
                        <div class="btn-group w-100 border mb-3" v-for="relatedPost in relation.related_posts"
                             :key="relatedPost.id">
                            <div class="w-100 px-3 align-self-center">{{ relatedPost?.title }}</div>
                            <router-link :to="{name: 'Post', params: {postType: relation.postType?.slug, id: relatedPost?.id}}" target="_blank"
                                         type="button" class="btn btn-light">
                                <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i>
                            </router-link>
                        </div>
                    </div>
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

export default {
    name: "Post",
    props: ['id', 'postType'],
    components: {MetaFields},
    data() {
        return {
            post: {},
            saving: false,
            tab: 'general'
        }
    },
    watch: {
        tab: function () {
            location.hash = `#${this.tab}`
        }
    },
    methods: {
        save: function () {
            this.saving = true
            this.postJson(`/api/posts/${this.postType}/${this.id}`, this.post, json => {
                this.post = json.data
                this.saving = false
            })
        }
    },
    mounted() {
        this.getJson(`/api/posts/${this.postType}/${this.id}`, json => this.post = json.data)
        if (location.hash) this.tab = location.hash.replace('#', '')
    }
}
</script>
