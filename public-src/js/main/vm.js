/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import '../../css/main.scss'

import Vue from 'vue'
import { ButtonPlugin, FormPlugin, FormGroupPlugin, FormInputPlugin, LayoutPlugin } from 'bootstrap-vue'
import { BootstrapVueIcons } from 'bootstrap-vue'

import components from './vm/components'
import filters from './vm/filters'
import plugins from './vm/plugins'
import router from './vm/router'
import store from './vm/store'

import userPanelComponent from './vm/components/layout/user-panel.vue'

Vue.use(ButtonPlugin)
Vue.use(FormPlugin)
Vue.use(FormGroupPlugin)
Vue.use(FormInputPlugin)
Vue.use(LayoutPlugin)
Vue.use(BootstrapVueIcons)

export default {
    init({ containerElement }) {
        return new Promise((resolve, reject) => {

            components.init()
            filters.init()
            plugins.init()

            this.instance = new Vue({
                el: containerElement,
                router: router.init(),
                store: store.init(),
                render(createElement) {
                    return createElement('div', {
                        attrs: {
                            id: 'inf-main-vm',
                        },
                    }, [
                        createElement(userPanelComponent),
                        createElement('router-view'),
                    ])
                },
                mounted() {
                    resolve()
                },
            })
        })
    },
}
