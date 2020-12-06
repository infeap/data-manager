/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import has from 'lodash/has'
import isArray from 'lodash/isArray'

import infetch from '../../../../../../foundation/http/request/infetch'

export default function ({ commit }) {

    return infetch.get('/api/v1/user/session').then((response) => {
        if (response.parsedBody) {
            if (has(response.parsedBody, 'user.isAuthenticated')) {
                commit('setIsAuthenticated', !! response.parsedBody.user.isAuthenticated)
            }

            if (has(response.parsedBody, 'user.offerLogin')) {
                commit('setOfferLogin', !! response.parsedBody.user.offerLogin)
            }

            if (has(response.parsedBody, 'dataSources')) {
                if (isArray(response.parsedBody.dataSources)) {
                    commit('dataSources/setList', response.parsedBody.dataSources, { root: true })
                }
            }
        } else {
            throw new Error('Unable to parse response body')
        }
    })
}
