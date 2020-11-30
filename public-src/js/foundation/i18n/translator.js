/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

import isEmpty from 'lodash/isEmpty'

import infetch from '../http/request/infetch'
import language from './language'

let loadedTranslations = {}

export default {
    loadTranslations(textDomain = 'js-main-vm', languageTag = null) {
        if (! languageTag) {
            languageTag = language.documentLanguage
        }

        return infetch.get('/api/v1/translations/' + languageTag + '/' + textDomain)
            .then((response) => {
                if (response.parsedBody) {
                    if (! loadedTranslations[languageTag]) {
                        loadedTranslations[languageTag] = {}
                    }

                    loadedTranslations[languageTag][textDomain] = response.parsedBody
                } else {
                    if (isEmpty(loadedTranslations)) {
                        throw new Error('Unable to parse response body')
                    } else {
                        console.warn('[Infeav Data Manager] Unable to parse response body of translations for ' + languageTag + '/' + textDomain)
                    }
                }
            })
    },
    translate(key, textDomain = 'js-main-vm', languageTag = null) {
        if (! languageTag) {
            languageTag = language.documentLanguage
        }

        if (loadedTranslations?.[languageTag]?.[textDomain]?.[key]) {
            return loadedTranslations[languageTag][textDomain][key]
        }

        console.warn('[Infeav Data Manager] Missing translation "' + key + '" in ' + languageTag + '/' + textDomain)

        if (language.fallbackLanguage) {
            if (loadedTranslations?.[language.fallbackLanguage]?.[textDomain]?.[key]) {
                return loadedTranslations[language.fallbackLanguage][textDomain][key]
            } else {
                loadedTranslations[language.fallbackLanguage] = {}

                this.loadTranslations(textDomain, language.fallbackLanguage)
            }
        }

        return '[' + key + ']'
    },
    translateOnDemand(key, textDomain = 'js-main-vm', languageTag = null) {
        if (key.startsWith('trans:')) {
            return this.translate(key.replace(/^trans:/, ''), textDomain, languageTag)
        } else {
            return key
        }
    },
    translateList(key, textDomain = 'js-main-vm', languageTag = null) {
        let translationList = []

        let i = 1

        while (i < 1024) {
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

        while (i < 1024) {
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
