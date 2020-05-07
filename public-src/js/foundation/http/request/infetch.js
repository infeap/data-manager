/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import isString from 'lodash/isString'

import app from '../../../init/app-array'

export default {
    get(resource, options = {}) {
        return fetch(this.prependBasePath(resource), {
            ...options,
            method: 'GET',
        }).then(this.checkResponseStatus.bind(this))
            .then(this.parseResponseBody.bind(this))
    },
    head(resource, options = {}) {
        return fetch(this.prependBasePath(resource), {
            ...options,
            method: 'HEAD',
        }).then(this.checkResponseStatus.bind(this))
            .then(this.parseResponseBody.bind(this))
    },
    post(resource, options = {}) {
        return fetch(this.prependBasePath(resource), {
            ...options,
            method: 'POST',
        }).then(this.checkResponseStatus.bind(this))
            .then(this.parseResponseBody.bind(this))
    },
    put(resource, options = {}) {
        return fetch(this.prependBasePath(resource), {
            ...options,
            method: 'PUT',
        }).then(this.checkResponseStatus.bind(this))
            .then(this.parseResponseBody.bind(this))
    },
    patch(resource, options = {}) {
        return fetch(this.prependBasePath(resource), {
            ...options,
            method: 'PATCH',
        }).then(this.checkResponseStatus.bind(this))
            .then(this.parseResponseBody.bind(this))
    },
    delete(resource, options = {}) {
        return fetch(this.prependBasePath(resource), {
            ...options,
            method: 'DELETE',
        }).then(this.checkResponseStatus.bind(this))
            .then(this.parseResponseBody.bind(this))
    },

    /*
     * Helpers
     */
    prependBasePath(resource) {
        if (isString(resource) && resource.startsWith('/')) {
            resource = app.basePath + resource.substr(1)
        }

        return resource
    },
    checkResponseStatus(response) {
        if (response.ok) {
            return response
        } else {
            return new Promise((resolve, reject) => {
                this.parseResponseBody(response).then((response) => {
                    reject({
                        response,
                    })
                }).catch((error) => {
                    reject(error)
                })
            })
        }
    },
    parseResponseBody(response) {
        switch (response.headers.get('Content-Type')) {
            case 'application/json':
                return new Promise((resolve, reject) => {
                    response.json().then((parsedBody) => {
                        response.parsedBody = parsedBody

                        resolve(response)
                    }).catch((error) => {
                        reject(error)
                    })
                })
            default:
                return response
        }
    },
}
