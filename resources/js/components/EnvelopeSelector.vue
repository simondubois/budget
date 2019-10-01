
<template>

    <select
        v-model="internalValue"
        class="form-control"
    >

        <option value="">
            {{ emptyOptionText }}
        </option>

        <envelope-selector-option
            v-for="envelope in envelopes"
            :key="envelope.id"
            :envelope="envelope"
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
            envelopes: vue => vue.$store.getters['envelope/all'],
            internalValue: {
                get: vue => vue.value,
                set(value) {
                    this.$emit('input', value);
                },
            },
        },
    };

</script>
