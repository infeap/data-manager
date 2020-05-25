<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component" data-name="routes/structure">
        <template v-if="loading">

            <div class="-loading text-center" style="margin: 6rem 0 4rem 0">
                <inf-spinner />
            </div>

        </template><template v-else>

            <inf-data-sources />

        </template>
    </div>
</template>

<script>
    import $ from 'jquery-slim'
    import get from 'lodash/get'

    import dataSourcesComponent from './structure/data-sources.vue'

    export default {
        data() {
            return {
                loading: true,
            }
        },
        components: {
            'inf-data-sources': dataSourcesComponent,
        },
        methods: {
            switchBodyLayout(name) {
                let $body = $('body')
                let $bodyArticle = $body.children('article:first')

                $body.removeClass('inf-has-basic-message inf-has-main-layout')
                $bodyArticle.removeClass('inf-basic-message inf-main-layout')

                switch (name) {
                    case 'basic-message':
                        $body.addClass('inf-has-basic-message')
                        $bodyArticle.addClass('inf-basic-message')
                        break
                    case 'main':
                        $body.addClass('inf-has-main-layout')
                        $bodyArticle.addClass('inf-main-layout')
                        break
                }
            },
            auth() {
                this.infetch.get('/api/v1/auth').then((response) => {
                    if (response.parsedBody) {
                        if (get(response.parsedBody, 'user.isAuthenticated')) {
                            if (response.parsedBody.dataSources) {
                                // ToDo: Show list
                                this.switchBodyLayout('main')
                            } else {
                                // ToDo: Show minimal user data + logout
                            }
                        } else {
                            if (response.parsedBody.dataSources) {
                                if (get(response.parsedBody, 'user.offerLogin')) {
                                    // ToDo: Show list + login fore "more" (with lock icon)
                                } else {
                                    // ToDo: Show list
                                }

                                this.switchBodyLayout('main')
                            } else {
                                if (get(response.parsedBody, 'user.offerLogin')) {
                                    // ToDo: Show login
                                } else {
                                    // ToDo: Show setup wizard
                                }
                            }
                        }

                        this.loading = false
                    } else {
                        throw new Error('Unable to parse response body')
                    }
                }).catch(() => {
                    // ToDo: Differentiate between recoverable and unrecoverable errors and show respective basic message template
                })
            },
        },
        mounted() {
            this.auth()
        },
    }
</script>
