/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import isString from 'lodash/isString'

import app from '../../init/app-array'

export default {

    /*
     * Core
     */
    fetch(method, resource, options = {}) {
        if (isString(resource) && options.query) {
            resource += '?' + new URLSearchParams(options.query).toString()
            delete options.query
        }

        return fetch(this.prependBasePath(resource), {
            ...options,
            method,
        }).then(this.checkResponseStatus.bind(this))
            .then(this.parseResponseBody.bind(this))
    },

    /*
     * Method shortcuts
     */
    get(resource, options = {}) {
        return this.fetch('GET', resource, options)
    },
    head(resource, options = {}) {
        return this.fetch('HEAD', resource, options)
    },
    post(resource, options = {}) {
        return this.fetch('POST', resource, options)
    },
    put(resource, options = {}) {
        return this.fetch('PUT', resource, options)
    },
    patch(resource, options = {}) {
        return this.fetch('PATCH', resource, options)
    },
    delete(resource, options = {}) {
        return this.fetch('DELETE', resource, options)
    },

    /*
     * JSON shortcuts
     */
    postJson(resource, options = {}) {
        return this.post(resource,
            this.prepareOptionsForJson(options))
    },
    putJson(resource, options = {}) {
        return this.put(resource,
            this.prepareOptionsForJson(options))
    },
    patchJson(resource, options = {}) {
        return this.patch(resource,
            this.prepareOptionsForJson(options))
    },
    deleteJson(resource, options = {}) {
        return this.delete(resource,
            this.prepareOptionsForJson(options))
    },

    /*
     * Internal helpers
     */
    prependBasePath(resource) {
        if (isString(resource) && resource.startsWith('/')) {
            resource = app.basePath + resource
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
        switch (response.headers.get('content-type')) {
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
    prepareOptionsForJson(options = {}) {
        options.headers ??= {}
        options.headers['content-type'] = 'application/json'

        if (options.body) {
            options.body = JSON.stringify(options.body)
        }

        return options
    },
}
