/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

'use strict'

const fs = require('fs')
const gitBranch = require('git-branch')
const path = require('path')

let appDir = path.dirname(__dirname)

let appPackageFile = path.join(appDir, '/package.json')

try {
    fs.accessSync(appPackageFile, fs.R_OK)
} catch (error) {
    console.error(appPackageFile + ' does not exist or is not readable')
    process.exit(1)
}

let appPackage = require(appPackageFile)

if (! appPackage.name || appPackage.name != 'infeap/data-manager') {
    console.error(appPackageFile + ' does not belong to the Infeap Data Manager project')
    process.exit(2)
}

let appVersionFile = path.join(appDir, '/version.json')

try {
    fs.accessSync(appVersionFile, fs.R_OK | fs.W_OK)
} catch (error) {
    console.error(appVersionFile + ' does not exist or is not readable or is not writable')
    process.exit(3)
}

let appVersion = require(appVersionFile)

appVersion.branch = gitBranch.sync()

if (appVersion.branch.includes('/')) {
    let branchSegments = appVersion.branch.split('/')
    let numberSegments = appVersion.number.split('/')

    if (numberSegments.length < branchSegments.length) {
        for (let i = 0; i <= branchSegments.length - numberSegments.length; i++) {
            numberSegments.push('0')
        }
    }

    numberSegments[numberSegments.length - 1] = (parseInt(numberSegments[numberSegments.length - 1]) + 1).toString()

    appVersion.number = numberSegments.join('/')
} else {
    appVersion.number = (parseInt(appVersion.number) + 1).toString()
}

let currentDateTime = (new Date()).toISOString()
let currentDate = currentDateTime.split('T')[0] + 'Z'

appVersion.date = currentDate

let appVersionFileContent = JSON.stringify(appVersion, null, 4) + '\n'

fs.writeFileSync(appVersionFile, appVersionFileContent)
