/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import $ from 'jquery'

$(document).ready(() => {

    $('.inf-error-trace').each((i, traceElement) => {
        let $traceElement = $(traceElement)
        let $traceItems = $traceElement.children()

        let showTraceItemsCount = 3

        $traceItems.each((j, traceItem) => {
            if (j >= showTraceItemsCount) {
                $(traceItem).addClass('sr-only')
            }
        })

        let $showMoreLink = $('<a href="#" aria-hidden="true">... +' + ($traceItems.length - showTraceItemsCount) + '</a>')

        $traceElement.append($showMoreLink)

        $showMoreLink.on('click', (event) => {
            event.preventDefault()

            $traceElement.find('.sr-only').removeClass('sr-only')

            $showMoreLink.remove()
        })
    })
})
