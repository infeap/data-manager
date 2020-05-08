/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes'

export default {
    init() {
        Vue.use(VueRouter)

        this.instance = new VueRouter({
            routes,
        })

        return this.instance
    },
}
