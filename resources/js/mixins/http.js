export default {
    methods: {
        getJson: function (url, callback) {
            fetch(url, {
                headers: {
                    'Authorization': `Bearer ${this.$root.$data.user.token}`
                }
            })
                .then(response => {
                    if (response.status === 403) {
                        this.$root.$data.user = null
                        localStorage.removeItem('_cms_user')
                        this.$router.push('/login')
                    } else if (response.status === 404) {
                        this.$router.push('/404')
                    } else {
                        return response.text()
                    }
                })
                .then(json => callback(json ? JSON.parse(json) : {}))
        },
        postJson: function (url, body, callback) {
            fetch(url, {
                method: 'POST',
                body: JSON.stringify(body),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.$root.$data.user.token}`
                }
            })
                .then(response => {
                    if (response.status === 403) {
                        this.$root.$data.user = null
                        localStorage.removeItem('_cms_user')
                        this.$router.push('/login')
                    } else {
                        return response.text()
                    }
                })
                .then(json => callback(json ? JSON.parse(json) : {}))
        },
        deleteRequest: function (url, callback) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${this.$root.$data.user.token}`
                }
            })
                .then(response => {
                    if (response.status === 403) {
                        this.$root.$data.user = null
                        localStorage.removeItem('_cms_user')
                        this.$router.push('/login')
                    } else {
                        return callback()
                    }
                })
        },
    }
}
