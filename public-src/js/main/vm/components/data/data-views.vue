<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component" data-name="data-views">
        <inf-data-view v-for="(dataPath, i) in dataPaths" :key="i"
            :data-path="dataPath" :is-active-view="i + 1 === dataPaths.length" />
    </div>
</template>

<script>
    import isString from 'lodash/isString'

    import dataView from './data-view.vue'

    export default {
        computed: {
            dataPaths() {
                let dataPaths = []

                if (this.$route.params.dataPath) {
                    let dataPathSegments = this.$route.params.dataPath

                    if (isString(dataPathSegments)) {
                        dataPathSegments = this.$route.params.dataPath.split('/')
                    }

                    for (let i = 1; i <= dataPathSegments.length; i++) {
                        dataPaths.push(dataPathSegments.slice(0, i).join('/'))
                    }
                }

                return dataPaths
            },
        },
        components: {
            'inf-data-view': dataView,
        },
    }
</script>
