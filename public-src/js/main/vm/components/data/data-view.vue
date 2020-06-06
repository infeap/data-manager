<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component" data-name="data-view">
        <template v-if="loading">

            <div class="-loading">
                <inf-spinner />
            </div>

        </template><template v-else>

            <nav>
                <ul>
                    <li v-for="childDataView in childDataViews" :key="childDataView.id">
                        <router-link :to="{ name: 'structure', params: { dataPath: [dataPath, childDataView.id] } }">
                            {{ childDataView.label | transOnDemand }}

                            <small v-if="childDataView.description">
                                {{ childDataView.description | transOnDemand }}
                            </small>
                        </router-link>
                    </li>
                </ul>
            </nav>

        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: true,
                childDataViews: [],
            }
        },
        props: {
            dataPath: {
                type: String,
                required: true,
            },
        },
        watch: {
            $route(toRoute) {
                if (toRoute.path == '/' + this.dataPath) {
                    this.load()
                }
            },
        },
        methods: {
            load() {
                this.loading = true

                this.infetch.get('/api/v1/data-view', {
                    query: {
                        path: this.dataPath,
                    },
                }).then((response) => {
                    if (response.parsedBody) {
                        this.childDataViews = response.parsedBody.childDataViews
                    } else {
                        throw new Error('Unable to parse response body')
                    }

                    this.loading = false
                }).catch(() => {
                    // ToDo
                })
            },
        },
        mounted() {
            this.load()
        },
    }
</script>
