<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template functional>
    <hr class="-partial" data-type="separator">
</template>

<script>
    export default {
        props: {
            dataPath: {
                type: String,
                required: true,
            },
            partial: {
                type: Object,
                required: true,
            },
        },
    }
</script>
