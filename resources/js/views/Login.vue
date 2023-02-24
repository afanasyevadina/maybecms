<template>
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body p-4">
                <form action="#" @submit.prevent="login">
                    <h1>Login</h1>
                    <hr>
                    <div class="mb-4">
                        <input type="email" v-model="form.email" class="form-control" placeholder="Email">
                    </div>
                    <div class="mb-4">
                        <input type="password"  v-model="form.password" class="form-control" placeholder="Password">
                    </div>
                    <p class="text-danger" v-if="error">
                        <small>{{ error }}</small>
                    </p>
                    <button class="btn btn-primary btn-lg w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            form: {},
            error: null
        }
    },
    methods: {
        login: function () {
            this.error = null
            fetch(`/api/admin/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.form)
            })
                .then(response => response.json())
                .then(json => {
                    if (json.status === 'error') {
                        this.error = json.message
                    } else {
                        this.$root.$data.user = json.data
                        localStorage.setItem('_cms_user', JSON.stringify(json.data))
                        this.$router.push('/pages')
                    }
                })
                .catch(err => console.log(err))
        }
    }
}
</script>
