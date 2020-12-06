<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component -data-view" data-name="data-view">
        <div class="-data-partials -card">
            <inf-load :flag="loading">
                <template v-if="dataPartials.length">
                    <inf-data-partial v-for="(dataPartial, i) in dataPartials" :key="i"
                        :data-path="dataPath" :data-partial="dataPartial" />
                </template><template v-else>
                    <div class="-no-data">{{ 'data_views.no_tools.label' | trans }}</div>
                </template>
            </inf-load>
        </div>

        <div class="-annotations -card" v-if="! loading && hasAnnotationsSupport && isActiveView">
            Comments and History
        </div>
    </div>
</template>

<script>
    import dataPartialComponent from './data-partial.vue'

    export default {
        data() {
            return {
                loading: true,

                dataPartials: [],
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
            'inf-data-partial': dataPartialComponent,
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
                        'data-path': this.dataPath,
                    },
                }).then((response) => {
                    if (response.parsedBody) {
                        this.dataPartials = response.parsedBody.dataPartials
                        this.hasAnnotationsSupport = response.parsedBody.hasAnnotationsSupport

                        if (this.isActiveView) {
                            if (this.dataPartials.length === 1 && this.dataPartials[0].type == 'sub_views' && this.dataPartials[0].subViews.length === 1) {
                                this.$router.replace({ name: 'structure', params: { dataPath: [...this.dataPath.split('/'), this.dataPartials[0].subViews[0].slug] } })
                            }
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
