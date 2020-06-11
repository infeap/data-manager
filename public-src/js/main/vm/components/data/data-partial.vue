<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <component :is="'inf-' + normalizedPartialType"
        :data-path="dataPath" :partial="partial" />
</template>

<script>
    import separator from './data-partials/separator.vue'
    import subViews from './data-partials/sub-views.vue'

    export default {
        props: {
            dataPath: {
                type: String,
                required: true,
            },
            partial: {
                type: Object,
                required: true,
            },
        },
        computed: {
            normalizedPartialType() {
                return this.partial.type.replace('/', '-').replace('_', '-')
            },
        },
        components: {
            'inf-separator': separator,
            'inf-sub-views': subViews,
        }
    }
</script>
