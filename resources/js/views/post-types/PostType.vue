<template>
    <div class="p-4" v-if="model.id">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="mb-4">{{ model.title }}</h1>
            <button type="button" class="btn btn-success mb-4" @click="save()">
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="saving"></span>
                Сохранить
            </button>
        </div>
        <div class="border p-4 bg-white mb-5">
            <div class="mb-4">
                <label>Singular title</label>
                <input type="text" v-model="model.title" class="form-control" required>
            </div>
            <div class="mb-4">
                <label>Plural title</label>
                <input type="text" v-model="model.plural_title" class="form-control" required>
            </div>
            <div>
                <label>Slug</label>
                <input type="text" v-model="model.slug" class="form-control" required pattern="^[\w-]*$">
            </div>
        </div>
        <h4 class="mb-3">Поля модели</h4>
        <div class="border p-4 bg-white mb-5">
            <div class="mb-4" v-for="(field, fieldIndex) in model.structure.fields">
                <div class="row align-items-end">
                    <div class="col">
                        <label>Название поля</label>
                        <input type="text" v-model="field.title" class="form-control">
                    </div>
                    <div class="col">
                        <label>Тип поля</label>
                        <select v-model="field.type" class="form-control">
                            <option :value="primitive.type" v-for="primitive in primitives" :key="primitive.type">{{ primitive.title }}</option>
                        </select>
                    </div>
                    <div class="col-auto ps-0">
                        <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-field-${fieldIndex}`">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" :id="`delete-field-${fieldIndex}`">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="#" @submit.prevent="model.structure.fields.splice(fieldIndex, 1)" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Подтверждение</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Если что, это поле будет сейчас удалено</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-bs-dismiss="modal">Да, удалите</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Не надо</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus"></i> Добавить поле
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" @click.prevent="addField(primitive)" v-for="primitive in primitives" :key="primitive.id">{{ primitive.title}}</a></li>
                </ul>
            </div>
        </div>
        <h4 class="mb-3">Отношения с другими моделями</h4>
        <div class="border p-4 bg-white mb-5">
            <div class="mb-4" v-for="(relation, relationIndex) in model.relations">
                <div class="row align-items-end">
                    <div class="col">
                        <label>Название</label>
                        <input type="text" v-model="relation.title" class="form-control">
                    </div>
                    <div class="col">
                        <label>Тип отношения</label>
                        <select v-model="relation.type" class="form-control">
                            <option :value="relationType.type" v-for="relationType in relations" :key="relationType.type">{{ relationType.title }}</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Связанная модель</label>
                        <select v-model="relation.related_post_type_id" class="form-control">
                            <option :value="relatedPostType.id" v-for="relatedPostType in models" :key="relatedPostType.id">{{ relatedPostType.title }}</option>
                        </select>
                    </div>
                    <div class="col-auto ps-0">
                        <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-relation-${relationIndex}`">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" :id="`delete-relation-${relationIndex}`">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="#" @submit.prevent="model.relations.splice(relationIndex, 1)" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Подтверждение</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Если что, эта связь будет сейчас удалена</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-bs-dismiss="modal">Да, удалите</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Не надо</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#add-relation">
                <i class="fas fa-plus"></i> Добавить отношение
            </button>
            <div class="modal fade" tabindex="-1" id="add-relation">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="#" @submit.prevent="addRelation()" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Добавить отношение</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-4">
                                <select v-model="newRelation.type" class="form-control">
                                    <option :value="null">Выберите тип отношения</option>
                                    <option :value="relationType.type" v-for="relationType in relations" :key="relationType.type">{{ relationType.title }}</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <select v-model="newRelation.related_post_type_id" class="form-control">
                                    <option :value="null">Выберите связанную модель</option>
                                    <option :value="relatedPostType.id" v-for="relatedPostType in models" :key="relatedPostType.id">{{ relatedPostType.title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" data-bs-dismiss="modal" :disabled="!newRelation.type || !newRelation.related_post_type_id">Создать</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <template v-if="model.inverse_relations?.length">
            <h4 class="mb-3">Использовано в отношениях</h4>
            <div class="border p-4 bg-white mb-5">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Модель</th>
                        <th>Название</th>
                        <th>Тип отношения</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="relation in model.inverse_relations" :key="relation.id">
                        <td>{{ relation.model?.title }}</td>
                        <td>{{ relation.title }}</td>
                        <td>{{ relation.type }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </div>
    <div class="text-center" v-else>
        <div class="spinner-grow text-secondary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Model",
    props: ['id'],
    data() {
        return {
            model: {},
            primitives: [],
            relations: [],
            models: [],
            newRelation: {type: null, related_post_type_id: null},
            saving: false
        }
    },
    methods: {
        save: function () {
            this.saving = true
            this.postJson(`/api/post-types/${this.id}`, this.model, json => {
                    this.model = json.data
                    this.saving = false
                })
        },
        addField: function (primitive) {
            this.model.structure.fields.push({
                type: primitive.type,
                title: `Field ${this.model.structure.fields.length + 1}`
            })
        },
        addRelation: function () {
            let model = this.models.find(v => v.id === this.newRelation.related_post_type_id)
            this.model.relations.push({...this.newRelation, title: this.newRelation.type === 'has-one' ? model.title : model.plural_title})
            this.newRelation = {type: null, related_post_type_id: null}
        }
    },
    mounted() {
        this.getJson(`/api/post-types/${this.id}`, json => this.model = json.data)
        this.getJson(`/api/primitives`, json => this.primitives = json.data)
        this.getJson(`/api/relations`, json => this.relations = json.data)
        this.getJson(`/api/post-types`, json => this.models = json.data)
    }
}
</script>
