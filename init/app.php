<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

require 'message.php';

if (! defined('PHP_VERSION_ID') || PHP_VERSION_ID < 70400) {
    if (function_exists('http_response_code')) {
        http_response_code(500);
    }

    infeav_render_init_message('PHP setup required', 'PHP 7.4+ is required for this application to work (currently running PHP ' . PHP_VERSION . ').');
}

return require 'autoloading.php';
