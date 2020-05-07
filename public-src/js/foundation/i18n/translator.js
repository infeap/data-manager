/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import app from '../../init/app-array'
import language from './language'

let loadedTranslations = {}

export default {
    loadTranslations(textDomain = 'js-main-vm', languageTag = null) {
        if (! languageTag) {
            languageTag = language.documentLanguage
        }

        return fetch(app.basePath + 'api/v1/translations/' + languageTag + '/' + textDomain)
            .then((response) => {
                // ToDo: Check HTTP status code
                return response.json()
            })
            .then((responseTranslations) => {
                if (! loadedTranslations[languageTag]) {
                    loadedTranslations[languageTag] = {}
                }

                loadedTranslations[languageTag][textDomain] = responseTranslations
            })
            .catch(() => {
                // ToDo: Handle failed request
            })
    },
    translate(key, textDomain = 'js-main-vm', languageTag = null) {
        if (! languageTag) {
            languageTag = language.documentLanguage
        }

        if (loadedTranslations[languageTag]) {
            if (loadedTranslations[languageTag][textDomain]) {
                if (loadedTranslations[languageTag][textDomain][key]) {
                    return loadedTranslations[languageTag][textDomain][key]
                }
            }
        }

        return '[' + key + ']'
    },
    translateList(key, textDomain = 'js-main-vm', languageTag = null) {
        let translationList = []

        let i = 1

        while (i < 1000) {
            let translationKey = key + '.' + i
            let translation = this.translate(translationKey, textDomain, languageTag)

            if (translation != '[' + translationKey + ']') {
                translationList.push(translation)
                i++
            } else {
                break
            }
        }

        return translationList
    },
    translatePlural(key, number, textDomain = 'js-main-vm', languageTag = null) {
        if (number == 1) {
            key += '.singular'
        } else {
            key += '.plural'
        }

        return this.translate(key, textDomain, languageTag)
    },
    translatePluralList(key, number, textDomain = 'js-main-vm', languageTag = null) {
        let translationList = []

        let i = 1

        while (i < 1000) {
            if (number == 1) {
                var translationKey = key + '.singular.' + i
            } else {
                var translationKey = key + '.plural.' + i
            }

            let translation = this.translate(translationKey, textDomain, languageTag)

            if (translation != '[' + translationKey + ']') {
                translationList.push(translation)
                i++
            } else {
                break
            }
        }

        return translationList
    },
}
