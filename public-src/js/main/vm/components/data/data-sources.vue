<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-component" data-name="data-sources">
        <nav>
            <ul>
                <li v-for="dataSource in dataSources" :key="dataSource.slug">
                    <span v-if="dataSource.icon" class="-icon">
                        <b-icon :icon="dataSource.icon" />
                    </span>

                    <router-link :to="{ name: 'structure', params: { dataPath: dataSource.slug } }">
                        {{ dataSource.label | transOnDemand }}

                        <small v-if="dataSource.description">
                            {{ dataSource.description | transOnDemand }}
                        </small>
                    </router-link>
                </li>

                <li v-if="offerLogin" key="login" class="-login">
                    <span class="-icon">
                        <b-icon icon="key-fill" />
                    </span>

                    <router-link :to="{ name: 'user/authenticate' }">
                        {{ 'user.login.label' | trans }}

                        <small>
                            {{ 'user.login.description' | trans }}
                        </small>
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        computed: {
            dataSources() {
                return this.$store.state.dataSources.list
            },
            offerLogin() {
                if (! this.$store.state.user.isAuthenticated && this.$store.state.user.offerLogin) {
                    return true
                } else {
                    return false
                }
            },
        },
    }
</script>
