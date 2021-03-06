/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import $ from 'jquery-slim'

let basePath

const app = {
    get basePath() {
        if (! basePath) {
            basePath = $('head meta[name="base-path"]').attr('content')
        }

        return basePath
    },
}

if (! __develop__) {
    __webpack_public_path__ = app.basePath + '/'
}

export default app
