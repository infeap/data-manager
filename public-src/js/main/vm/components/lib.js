/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import Vue from 'vue'

import slideUpDown from 'vue-slide-up-down'

import loading from './lib/loading.vue'
import spinner from './lib/spinner.vue'

export default {
    init() {
        Vue.component('slide-up-down', slideUpDown)

        Vue.component('inf-load', loading)
        Vue.component('inf-spinner', spinner)
    },
}
