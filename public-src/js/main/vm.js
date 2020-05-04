/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import Vue from 'vue'

import components from './vm/components'
import plugins from './vm/plugins'
import router from './vm/router'
import store from './vm/store'

export default {
    init({ element }) {
        return new Promise((resolve, reject) => {

            components.init()
            plugins.init()

            this.instance = new Vue({
                el: element,
                router: router.init(),
                store: store.init(),
                render(createElement) {
                    return createElement('router-view')
                },
                mounted() {
                    resolve()
                },
            })
        })
    },
}
