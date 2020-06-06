<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div>
        <template v-if="flag">
            <div class="-loading">
                <inf-spinner />
            </div>
        </template><template v-else>
            <slot />
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            flag: {
                type: Boolean,
                required: true,
            },
        },
    }
</script>
