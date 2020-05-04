<!--
    This file is part of the
    Infeap Data Manager (https://www.infeap.org/data-manager)
    open source project.

    @copyright   2018-2020 Tobias Krebs and the Infeap Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <figure class="inf-spinner" :data-type="type">
        <div class="spinner-border" role="status"></div>

        <figcaption>
            {{ label }}
        </figcaption>
    </figure>
</template>

<script>
    import translator from '../../../../foundation/i18n/translator'

    export default {
        props: {
            type: {
                type: String,
                default: 'horizontal',
            },
            label: {
                type: String,
                default: translator.translate('loading.label'),
            },
        },
    }
</script>
