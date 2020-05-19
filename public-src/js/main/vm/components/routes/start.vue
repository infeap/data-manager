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

                    } else {
                        throw new Error('Unable to parse response body')
                    }
                })
            },
        },
        mounted() {
            this.auth()
        },
    }
</script>
