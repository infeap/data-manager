/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import http from './plugins/http'
import i18n from './plugins/i18n'

export default {
    init() {
        http.init()
        i18n.init()
    },
}
