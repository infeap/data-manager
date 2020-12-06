<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <component :is="'inf-' + normalizedFieldType"
        :data-path="dataPath" :data-partial="dataPartial" :field="field"
        @input="$emit('input', $event)" />
</template>

<script>
    import fieldMixin from './field-mixin'

    import textComponent from './fields/text.vue'

    export default {
        mixins: [
            fieldMixin,
        ],
        components: {
            'inf-text': textComponent,
        },
        computed: {
            normalizedFieldType() {
                return this.field.type.split('/')[0].replaceAll('_', '-')
            },
        },
    }
</script>
