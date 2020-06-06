/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import Vue from 'vue'

import translator from '../../../../foundation/i18n/translator'

export default {
    init() {
        Vue.filter('trans', (key, textDomain = 'js-main-vm', languageTag = null) => {
            return translator.translate(key, textDomain, languageTag)
        })

        Vue.filter('transOnDemand', (key, textDomain = 'js-main-vm', languageTag = null) => {
            return translator.translateOnDemand(key, textDomain, languageTag)
        })

        Vue.filter('transList', (key, textDomain = 'js-main-vm', languageTag = null) => {
            return translator.translateList(key, textDomain, languageTag)
        })

        Vue.filter('transPlural', (key, number, textDomain = 'js-main-vm', languageTag = null) => {
            return translator.translatePlural(key, number, textDomain, languageTag)
        })

        Vue.filter('transPluralList', (key, number, textDomain = 'js-main-vm', languageTag = null) => {
            return translator.translatePluralList(key, number, textDomain, languageTag)
        })
    },
}
