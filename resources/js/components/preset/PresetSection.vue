<template>
    <div>
        <preset-field v-for="(block, blockIndex) in (editable.blocks || [])" :block="block" :key="block.id" @remove="editable.blocks.splice(blockIndex, 1)"></preset-field>
        <Controls @addBlock="addBlock" @addPreset="addPreset"></Controls>
    </div>
</template>

<script>
import Controls from "./Controls.vue";

export default {
    name: "PresetSection",
    props: {
        editable: {
            type: Object
        }
    },
    components: {Controls},
    methods: {
        addBlock: function (block) {
            this.editable.blocks.push({
                type: block.type,
                title: block.title,
                blocks: []
            })
        },
        addPreset: function (preset) {
            this.editable.blocks = this.editable.blocks?.concat(preset.blocks)
        }
    }
}
</script>
