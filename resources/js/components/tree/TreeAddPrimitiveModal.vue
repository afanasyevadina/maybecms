<template>
    <div class="modal fade" tabindex="-1" :id="modalKey">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add primitive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 mb-3" v-for="primitive in primitives" :key="primitive.id">
                            <a href="#" class="btn btn-outline-dark w-100 h-100" data-bs-dismiss="modal"
                               @click.prevent="$emit('addBlock', primitive)">{{ primitive.title }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TreeAddPrimitiveModal",
    props: {
        modalKey: {
            type: String
        }
    },
    data() {
        return {
            primitives: [],
        }
    },
    mounted() {
        this.getJson(`/api/primitives`, json => this.primitives = json.data)
    }
}
</script>
