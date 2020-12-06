<!--
    This file is part of the
    Infeav Data Manager (https://www.infeav.org/data-manager)
    open source project

    @copyright   2018-2020 Tobias Krebs and the Infeav Team
    @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
-->

<template>
    <b-form class="-data-partial" data-type="fields" @submit.prevent="save">
        <div class="text-right">
            <b-button type="submit" variant="primary">
                {{ 'data_partials.fields.save.label' | trans }}
            </b-button>
        </div>

        <inf-field v-for="field in fields" :key="field.name"
            :data-path="dataPath" :data-partial="dataPartial" :field="field"
            @input="field.value = $event" />
    </b-form>
</template>

<script>
    import dataPartialMixin from '../data-partial-mixin'

    import fieldComponent from './field.vue'

    export default {
        mixins: [
            dataPartialMixin,
        ],
        data() {
            return {
                fields: this.dataPartial.fields,
            }
        },
        components: {
            'inf-field': fieldComponent,
        },
        methods: {
            save() {
                let body = []

                for (let field of this.fields) {
                    body.push({
                        name: field.name,
                        value: field.value,
                    })
                }

                this.infetch.postJson('/api/v1/data-fields', { // ToDo: PATCH when existing entity
                    query: {
                        'data-path': this.dataPath,
                    },
                    body,
                })
            },
        },
    }
</script>
