<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <nav class="-data-partial" data-type="sub-views">
        <template v-if="dataPartial.subViews.length">
            <ul>
                <li v-for="subView in dataPartial.subViews" :key="subView.slug">
                    <router-link :to="{ name: 'structure', params: { dataPath: [...dataPathSegments, subView.slug] } }">
                        <b-icon v-if="subView.icon" :icon="subView.icon" class="mr-1" />

                        {{ subView.label | transOnDemand }}

                        <small v-if="subView.description">
                            {{ subView.description | transOnDemand }}
                        </small>
                    </router-link>
                </li>
            </ul>
        </template><template v-else>
            <div class="-no-data">{{ 'data_views.no_data.label' | trans }}</div>
        </template>
    </nav>
</template>

<script>
    import dataPartialMixin from '../data-partial-mixin'

    export default {
        mixins: [
            dataPartialMixin,
        ],
        computed: {
            dataPathSegments() {
                return this.dataPath.split('/')
            },
        },
    }
</script>
