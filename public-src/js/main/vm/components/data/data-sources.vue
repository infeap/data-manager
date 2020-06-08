<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component" data-name="data-sources">
        <nav>
            <ul>
                <li v-for="dataSource in dataSources" :key="dataSource.id">
                    <div v-if="dataSource.icon" class="-icon">
                        <b-icon :icon="dataSource.icon" />
                    </div>

                    <router-link :to="{ name: 'structure', params: { dataPath: dataSource.id } }">
                        {{ dataSource.label | transOnDemand }}

                        <small v-if="dataSource.description">
                            {{ dataSource.description | transOnDemand }}
                        </small>
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        computed: {
            dataSources: {
                get() {
                    return this.$store.state.dataSources.list
                },
            },
        },
    }
</script>
