<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div>
        <div v-if="loading"
            class="text-center" style="margin: 6rem 0 4rem 0">

            <inf-spinner />
        </div>
    </div>
</template>

<script>
    import get from 'lodash/get'

    export default {
        data() {
            return {
                loading: true,
            }
        },
        methods: {
            auth() {
                this.infetch.get('/api/v1/auth').then((response) => {
                    if (response.parsedBody) {
                        if (get(response.parsedBody, 'user.isAuthenticated')) {
                            if (response.parsedBody.dataSources) {
                                // ToDo: Show list
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
                            } else {
                                if (get(response.parsedBody, 'user.offerLogin')) {
                                    // ToDo: Show login
                                } else {
                                    // ToDo: Show setup wizard
                                }
                            }
                        }
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
