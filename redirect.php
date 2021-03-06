<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

/*
 * Redirect every request into the public/ directory
 * basically concealing all other directories and files
 */

$basePath = rtrim(dirname($_SERVER['PHP_SELF']), '/');

if ($basePath) {
    $requestPath = substr($_SERVER['REQUEST_URI'], strlen($basePath));
} else {
    $requestPath = $_SERVER['REQUEST_URI'];
}

header('location: ' . $basePath . '/public' . $requestPath);
