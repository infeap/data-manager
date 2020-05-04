/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import Vue from 'vue'

import slideUpDown from 'vue-slide-up-down'

import spinner from './lib/spinner.vue'

export default {
    init() {
        Vue.component('slide-up-down', slideUpDown)

        Vue.component('inf-spinner', spinner)
    },
}
