<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

/*
 * Redirect every request into the public/ directory
 * basically concealing all other directories and files
 */

$basePath = dirname($_SERVER['PHP_SELF']);

if (strlen($basePath) > 1) {
    $requestPath = substr($_SERVER['REQUEST_URI'], strlen($basePath));
} else {
    $requestPath = $_SERVER['REQUEST_URI'];
}

header('Location: ' . $basePath . '/public' . $requestPath);
