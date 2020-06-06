<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-child-data-view">
        <template v-if="childDataView.type == 'separator'">
            <inf-separator />
        </template><template v-else>
            <inf-link :data-path="dataPath" :child-data-view="childDataView" />
        </template>
    </div>
</template>

<script>
    import linkComponent from './child-data-view/link.vue'
    import separatorComponent from './child-data-view/separator.vue'

    export default {
        props: {
            dataPath: {
                type: String,
                required: true,
            },
            childDataView: {
                type: Object,
                required: true,
            },
        },
        components: {
            'inf-link': linkComponent,
            'inf-separator': separatorComponent,
        },
    }
</script>
