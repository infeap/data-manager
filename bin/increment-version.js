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

let version = require('../version')

version.number++

let currentDateTime = (new Date()).toISOString()
let currentDate = currentDateTime.split('T')[0] + 'Z'

version.date = currentDate

version.branch = gitBranch.sync()

let versionFileContent = JSON.stringify(version, null, 4) + '\n'

fs.writeFileSync('version.json', versionFileContent)
