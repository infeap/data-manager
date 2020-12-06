<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component -has-structure-container" data-name="routes/user/authenticate">
        <inf-load-structure :flag="loading">
            <inf-data-sources />

            <div class="-data-views-container">
                <div class="-data-view">
                    <div class="-data-partials -card">
                        Login Form
                    </div>
                </div>
            </div>
        </inf-load-structure>
    </div>
</template>

<script>
    import structureMixin from '../structure-mixin'

    export default {
        mixins: [
            structureMixin,
        ],
        methods: {
            init() {
                if (this.$store.state.user.isAuthenticated || ! this.$store.state.user.offerLogin) {
                    // ToDo: Redirect to structure route
                    // ToCheck: Redirect cancels component execution?
                }

                if (this.$store.state.dataSources.list.length) {
                    this.switchBodyLayout('main')
                } else {
                    // ToDo: Show (singular) login form
                }
            },
        },
    }
</script>
