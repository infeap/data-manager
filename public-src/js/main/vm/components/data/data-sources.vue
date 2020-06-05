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
                <li v-for="dataSource in dataSources" :key="dataSource.id">
                    <div class="-icon">
                        <b-icon :icon="getDataSourceIcon(dataSource)" />
                    </div>

                    <router-link :to="{ name: 'structure', params: { dataPath: dataSource.id } }">
                        {{ dataSource.label }}

                        <small v-if="dataSource.description">
                            {{ dataSource.description }}
                        </small>
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import {
        BIcon,
        BIconServer,
        BIconFolder,
        BIconFileEarmark,
        BIconFolderSymlink,
        BIconFileEarmarkArrowDown,
        BIconInboxFill,
        BIconTools,
        BIconFile,
    } from 'bootstrap-vue'

    export default {
        computed: {
            dataSources: {
                get() {
                    return this.$store.state.dataSources.list
                },
            },
        },
        components: {
            BIcon,
            BIconServer,
            BIconFolder,
            BIconFileEarmark,
            BIconFolderSymlink,
            BIconFileEarmarkArrowDown,
            BIconInboxFill,
            BIconTools,
            BIconFile,
        },
        methods: {
            getDataSourceIcon(dataSource) {
                switch (dataSource.type) {
                    case 'db/ibm_db2':
                    case 'db/maria':
                    case 'db/mysql':
                    case 'db/oci8':
                    case 'db/pgsql':
                    case 'db/sqlite':
                    case 'db/sqlsrv':
                        return 'server'

                    case 'fs/directory':
                        return 'folder'

                    case 'fs/file':
                        return 'file-earmark'

                    case 'remote/ftp':
                    case 'remote/sftp':
                        return 'folder-symlink'

                    case 'remote/http':
                        return 'file-earmark-arrow-down'

                    case 'remote/ldap':
                        return 'folder-symlink'

                    case 'remote/mail':
                        return 'inbox-fill'

                    case 'remote/webdav':
                        return 'folder-symlink'

                    case 'reflection':
                        return 'tools'

                    default:
                        return 'file'
                }
            },
        },
    }
</script>
