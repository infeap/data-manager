'use strict'

const fs = require('fs')

let version = require('../version')

version.number++

let currentDateTime = (new Date()).toISOString()
let currentDate = currentDateTime.split('T')[0] + 'Z'

version.date = currentDate

let versionFileContent = JSON.stringify(version, null, 4)

fs.writeFileSync('version.json', versionFileContent)
