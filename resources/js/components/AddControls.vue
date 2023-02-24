<template>
    <div>
        <a href="#" class="text-dark add-controls" data-bs-toggle="modal" :data-bs-target="`#add-controls-${id}`">
            <i class="fas fa-plus small"></i>
        </a>
        <div class="modal fade" tabindex="-1" :id="modalKey">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn btn-outline-dark w-100" data-bs-dismiss="modal"
                                @click="$emit('addBlock', {type:'section', title: 'Section'})">
                            Add block
                        </button>
                        <hr>
                        Add primitive
                        <div class="row collapse show" :id="`add-primitive-controls-${id}`">
                            <div class="col-4 mt-3" v-for="primitive in primitives" :key="primitive.id">
                                <a href="#" class="btn btn-outline-dark w-100 h-100" data-bs-dismiss="modal"
                                   @click.prevent="$emit('addBlock', primitive)">{{ primitive.title }}</a>
                            </div>
                        </div>
                        <template v-if="presets.length">
                            <hr>
                            Choose preset
                            <div class="row collapse show" :id="`add-preset-controls-${id}`">
                                <div class="col-4 mt-3" v-for="preset in presets" :key="preset.id">
                                    <a href="#" class="btn btn-outline-dark w-100 h-100" data-bs-dismiss="modal"
                                       @click.prevent="$emit('addPreset', preset)">{{ preset.title }}</a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AddControls",
    props: {
        modalKey: {
            type: String
        }
    },
    data() {
        return {
            primitives: [],
            presets: []
        }
    },
    mounted() {
        this.getJson(`/api/admin/primitives`, json => this.primitives = json.data)
        this.getJson(`/api/admin/presets`, json => this.presets = json.data)
    }
}
</script>
