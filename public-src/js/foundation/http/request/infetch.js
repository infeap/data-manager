/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import isString from 'lodash/isString'

import app from '../../../init/app-array'

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
            method: method.toUpperCase(),
        }).then(this.checkResponseStatus.bind(this))
            .then(this.parseResponseBody.bind(this))
    },

    /*
     * Request method shortcuts
     */
    get(resource, options = {}) {
        return this.fetch('get', resource, options)
    },
    head(resource, options = {}) {
        return this.fetch('head', resource, options)
    },
    post(resource, options = {}) {
        return this.fetch('post', resource, options)
    },
    put(resource, options = {}) {
        return this.fetch('put', resource, options)
    },
    patch(resource, options = {}) {
        return this.fetch('patch', resource, options)
    },
    delete(resource, options = {}) {
        return this.fetch('delete', resource, options)
    },

    /*
     * JSON shortcuts
     */
    postJSON(resource, options = {}) {
        return this.post(resource,
            this.prepareOptionsForJSON(options))
    },
    putJSON(resource, options = {}) {
        return this.put(resource,
            this.prepareOptionsForJSON(options))
    },
    patchJSON(resource, options = {}) {
        return this.patch(resource,
            this.prepareOptionsForJSON(options))
    },
    deleteJSON(resource, options = {}) {
        return this.delete(resource,
            this.prepareOptionsForJSON(options))
    },

    /*
     * Internal helpers
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
    prepareOptionsForJSON(options = {}) {
        options.headers ??= {}
        options.headers['Content-Type'] = 'application/json'

        if (options.body) {
            options.body = JSON.stringify(options.body)
        }

        return options
    },
}
