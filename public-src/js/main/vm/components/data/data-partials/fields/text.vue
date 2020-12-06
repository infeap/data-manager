<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <div class="-field" data-type="text">
        <b-form-group
            :id="fieldDomId + '/form-group'"
            :label="field.label | transOnDemand"
            :label-for="fieldDomId + '/form-control'">

            <b-form-input
                :id="fieldDomId + '/form-control'"
                :name="field.name"
                :value="field.value"
                @input="$emit('input', $event)" />
        </b-form-group>
    </div>
</template>

<script>
    import fieldMixin from '../field-mixin'

    export default {
        mixins: [
            fieldMixin,
        ],
    }
</script>
