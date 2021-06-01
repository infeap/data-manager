/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import app from '../../init/app-array'

export default {

    /**
     * Core method
     *
     * .then((response) => { response.ok, response.status, response.parsedBody, ... })
     *
     * .catch((error) => {
     *     error.response
     *     || error instanceof AbortError
     *     || error instanceof TypeError (e. g. on CORS)
     *     || error instanceof SyntaxError (e. g. when parsing invalid JSON responses)
     * })
     */
    fetch(method, resource, options = {}) {
        if (typeof resource == 'string') {
            if (typeof options.params == 'object') {
                for (let [paramKey, paramValue] of Object.entries(options.params)) {
                    let paramKeySearch = '/:' + paramKey
                    let paramReplacement = '/' + encodeURIComponent(paramValue)

                    if (resource.endsWith(paramKeySearch)) {
                        resource = resource.replace(paramKeySearch, paramReplacement)
                    } else {
                        resource = resource.replace(paramKey + '/', paramReplacement + '/')
                    }
                }
                delete options.params
            }

            if (options.query) {
                resource += '?' + new URLSearchParams(options.query).toString()
                delete options.query
            }
        }

        try {
            return fetch(resource, {
                ...options,
                method,
            }).then(this.checkResponseStatus.bind(this))
                .then(this.parseResponseBody.bind(this))
        } catch (error) {
            return Promise.reject(error)
        }
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
        if (typeof resource == 'string' && resource.startsWith('/')) {
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
                })
            })
        }
    },
    parseResponseBody(response) {
        let contentType = response.headers.get('content-type')?.split(';')?.[0]?.trim()

        if (contentType == 'application/json') {
            return new Promise((resolve, reject) => {
                response.json().then((parsedBody) => {
                    response.parsedBody = parsedBody
                    resolve(response)
                })
            })
        }

        if (contentType.startsWith('text/')) {
            return new Promise((resolve, reject) => {
                response.text().then((parsedBody) => {
                    response.parsedBody = parsedBody
                    resolve(response)
                })
            })
        }

        return response
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
