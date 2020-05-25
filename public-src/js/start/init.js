/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import $ from 'jquery-slim'

import translator from '../foundation/i18n/translator'

$(document).ready(() => {

    let $startElement = $('#inf-start')

    if ($startElement.length) {

        translator.loadTranslations().then(() => {

            import(
                /* webpackChunkName: "dynamic/main/vm" */
                /* webpackMode: "lazy" */
                '../main/vm').then((mainVmModule) => {

                    let mainVm = mainVmModule.default

                    let $mainVmElement = $('<div id="inf-main-vm"></div>')

                    $startElement.before($mainVmElement)

                    mainVm.init({ rootElement: $mainVmElement[0] }).then(() => {
                        $startElement.remove()
                    })
                }
            )
        }).catch((error) => {
            console.warn('[Infeav Data Manager] Unable to load main VM translations',
                error.response && error.response.parsedBody ? error.response.parsedBody : error)
        })
    } else {
        console.warn('[Infeav Data Manager] #inf-start element required to init main UI')
    }
})
