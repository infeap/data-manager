<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <component :is="'inf-' + normalizedPartialType"
        :data-path="dataPath" :data-partial="dataPartial" />
</template>

<script>
    import dataPartialMixin from './data-partial-mixin'

    import fieldsComponent from './data-partials/fields.vue'
    import subViewsComponent from './data-partials/sub-views.vue'

    export default {
        mixins: [
            dataPartialMixin,
        ],
        components: {
            'inf-fields': fieldsComponent,
            'inf-sub-views': subViewsComponent,
        },
        computed: {
            normalizedPartialType() {
                return this.dataPartial.type.split('/')[0].replaceAll('_', '-')
            },
        },
    }
</script>
