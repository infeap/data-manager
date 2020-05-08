/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import $ from 'jquery-slim'

$(document).ready(() => {

    $('.inf-error-trace').each((i, traceContainer) => {
        let $traceContainer = $(traceContainer)
        let $traceElements = $traceContainer.children()

        let showTraceElements = 3

        $traceElements.each((j, traceElement) => {
            if (j >= showTraceElements) {
                $(traceElement).addClass('sr-only')
            }
        })

        let $showMoreLink = $('<a href="#" aria-hidden="true">... +' + ($traceElements.length - showTraceElements) + '</a>')

        $traceContainer.append($showMoreLink)

        $showMoreLink.on('click', (event) => {
            event.preventDefault()

            $traceContainer.find('.sr-only').removeClass('sr-only')

            $showMoreLink.remove()
        })
    })
})
