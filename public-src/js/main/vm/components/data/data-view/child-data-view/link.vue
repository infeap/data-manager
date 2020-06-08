<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <router-link class="-link" :to="{ name: 'structure', params: { dataPath: [...dataPathSegments, childDataView.id] } }">
        <b-icon v-if="childDataView.icon" :icon="childDataView.icon" class="mr-1" />

        {{ childDataView.label | transOnDemand }}

        <small v-if="childDataView.description">
            {{ childDataView.description | transOnDemand }}
        </small>
    </router-link>
</template>

<script>
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
        computed: {
            dataPathSegments() {
                return this.dataPath.split('/')
            },
        },
    }
</script>
