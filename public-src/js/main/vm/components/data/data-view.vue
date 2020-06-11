<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component" data-name="data-view">
        <div class="-partials -card">
            <inf-load :flag="loading">
                <template v-if="partials.length">
                    <inf-data-partial v-for="(partial, i) in partials" :key="i"
                        :data-path="dataPath" :partial="partial" />
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
    import partialComponent from './data-partial.vue'

    export default {
        data() {
            return {
                loading: true,
                partials: [],
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
            'inf-data-partial': partialComponent,
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
                        this.partials = response.parsedBody.partials
                        this.hasAnnotationsSupport = response.parsedBody.hasAnnotationsSupport

                        if (this.partials.length === 1 && this.partials[0].type == 'sub_views' && this.partials[0].subViews.length === 1) {
                            this.$router.replace({ name: 'structure', params: { dataPath: [...this.dataPath.split('/'), this.partials[0].subViews[0].id] } })
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
