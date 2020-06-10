<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component" data-name="data-view">
        <div class="-data -card">
            <inf-load :flag="loading">
                <template v-if="childDataViews.length">
                    <nav>
                        <ul>
                            <li v-for="childDataView in childDataViews" :key="childDataView.id">
                                <inf-child-data-view :data-path="dataPath" :child-data-view="childDataView" />
                            </li>
                        </ul>
                    </nav>
                </template><template v-else>
                    <div class="-no-data">{{ 'data_views.no_data.label' | trans }}</div>
                </template>
            </inf-load>
        </div>

        <div class="-annotations -card" v-if="hasAnnotationsSupport && isActiveView">
            Comments and History
        </div>
    </div>
</template>

<script>
    import childDataViewComponent from './data-view/child-data-view.vue'

    export default {
        data() {
            return {
                loading: true,
                childDataViews: [],
                hasAnnotationsSupport: false,
            }
        },
        props: {
            dataPath: {
                type: String,
                required: true,
            },
            isActiveView: {
                type: Boolean,
                default: false,
            },
        },
        components: {
            'inf-child-data-view': childDataViewComponent,
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
                        this.hasAnnotationsSupport = response.parsedBody.hasAnnotationsSupport

                        if (this.childDataViews.length === 1) {
                            this.$router.replace({ name: 'structure', params: { dataPath: [...this.dataPath.split('/'), this.childDataViews[0].id] } })
                        }
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
