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
