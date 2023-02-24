export default {
    methods: {
        nl2br: function (str) {
            return (str || '').replaceAll('\n', '<br>')
        },
        formatSize: function (size) {
            size = Math.round((size * 100) / 1024) / 100
            return size >= 1024 ? `${Math.round((size * 100) / 1024) / 100} mb` : `${size} kb`
        }
    }
}
