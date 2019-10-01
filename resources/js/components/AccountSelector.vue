
<template>

    <select
        v-model="internalValue"
        class="form-control"
    >

        <option value="">
            {{ emptyOptionText }}
        </option>

        <account-selector-bank
            v-for="bank in banks"
            :key="bank"
            :bank="bank"
        />

    </select>

</template>



<script>

    export default {
        props: {
            emptyOptionText: {
                type: String,
                default: '',
            },
            value: {
                type: [Number, String],
                required: true,
            },
        },
        computed: {
            banks: vue => vue.$store.getters['account/banks'],
            internalValue: {
                get: vue => vue.value,
                set(value) {
                    this.$emit('input', value);
                },
            },
        },
    };

</script>
