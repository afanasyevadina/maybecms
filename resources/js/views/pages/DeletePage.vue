<template>
    <div class="modal fade" :id="`delete-page-${this.id}`" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="remove">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить страницу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Вы точно хотите удалить эту страницу?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Да, удалите ее</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Я передумал</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

export default {
    name: 'DeletePage',
    props: ['id'],
    methods: {
        remove: function () {
            this.deleteRequest(`/api/pages/${this.id}`,() => {
                    this.$router.push({name: 'Pages'})
                    location.reload()
                })
        }
    }
}
</script>
