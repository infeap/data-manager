/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import translator from '../../../../foundation/i18n/translator'

export default {
    install(Vue) {
        Vue.mixin({
            methods: {
                translate: translator.translate,
                translateList: translator.translateList,
                translatePlural: translator.translatePlural,
                translatePluralList: translator.translatePluralList,
            },
        })
    },
}
