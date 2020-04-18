<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

if (! function_exists('infeap_render_init_message')) {

    function infeap_render_init_message($heading, $text) {

        $fromPublic = true;

        require '../index.php';
        exit();
    }
}
