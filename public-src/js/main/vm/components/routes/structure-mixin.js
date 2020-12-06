/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import $ from 'jquery-slim'

import loadStructureComponent from './structure-load.vue'
import dataSourcesComponent from '../data/data-sources.vue'

export default {
    data() {
        return {
            loading: true,
        }
    },
    components: {
        'inf-load-structure': loadStructureComponent,
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
        getUserSession() {
            this.$store.dispatch('user/getSession').then(() => {
                this.init()
                this.loading = false
            }).catch(() => {
                // ToDo: Differentiate between recoverable and unrecoverable errors and show respective basic message template
            })
        },
    },
    mounted() {
        this.getUserSession()
    },
}
