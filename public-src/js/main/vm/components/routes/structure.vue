<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component -has-structure-container" data-name="routes/structure">
        <inf-load-structure :flag="loading">
            <inf-data-sources />
            <inf-data-views />
        </inf-load-structure>
    </div>
</template>

<script>
    import structureMixin from './structure-mixin'

    import dataViewsComponent from '../data/data-views.vue'

    export default {
        mixins: [
            structureMixin,
        ],
        components: {
            'inf-data-views': dataViewsComponent,
        },
        methods: {
            init() {
                if (this.$store.state.user.isAuthenticated) {
                    if (this.$store.state.dataSources.list.length) {
                        this.switchBodyLayout('main')
                    } else {
                        // ToDo: Redirect to (minimal; basic message?) user data ("dashboard" panel) + logout option
                    }
                } else {
                    if (this.$store.state.dataSources.list.length) {
                        this.switchBodyLayout('main')
                    } else {
                        if (this.$store.state.user.offerLogin) {
                            // ToDo: Redirect to user/auth route
                        } else {
                            // ToDo: Show setup wizard
                        }
                    }
                }
            },
        },
    }
</script>
