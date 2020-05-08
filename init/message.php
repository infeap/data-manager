<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

if (! function_exists('infeav_render_init_message')) {

    function infeav_render_init_message($heading, $text) {

        $fromPublic = true;

        require '../index.php';
        exit();
    }
}
