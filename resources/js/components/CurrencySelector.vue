
<template>

    <select
        v-model="internalValue"
        class="form-control"
    >

        <option
            v-if="emptyOptionText"
            value=""
        >
            {{ emptyOptionText }}
        </option>

        <option
            v-for="currency in currencies"
            :key="currency.iso"
            :value="currency.iso"
        >

            <template v-if="showName">
                {{ currency.name }} ({{ currency.unit }})
            </template>

            <template v-else>
                {{ currency.unit }}
            </template>

        </option>

    </select>

</template>



<script>

    export default {
        props: {
            emptyOptionText: {
                type: String,
                default: '',
            },
            showName: {
                type: Boolean,
                default: false,
            },
            value: {
                type: [Number, String],
                required: true,
            },
        },
        computed: {
            currencies: vue => vue.$store.getters['currency/all'],
            internalValue: {
                get: vue => vue.value,
                set(value) {
                    this.$emit('input', value);
                },
            },
        },
    };

</script>
