/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

'use strict'

const fs = require('fs')
const glob = require('glob')
const path = require('path')

let appDir = path.dirname(path.dirname(__dirname))

let appPackageFile = path.join(appDir, 'package.json')

try {
    fs.accessSync(appPackageFile, fs.R_OK)
} catch (error) {
    console.error(appPackageFile + ' does not exist or is not readable')
    process.exit(1)
}

let appPackage = require(appPackageFile)

if (! appPackage.name || appPackage.name !== '@infeav/data-manager') {
    console.error(appPackageFile + ' does not belong to the Infeav Data Manager project')
    process.exit(2)
}

let globPattern = path.join(appDir, 'var/cache/version-*')

for (let versionedCacheDir of glob.sync(globPattern)) {
    fs.rmdirSync(versionedCacheDir, {
        recursive: true,
    })
}
