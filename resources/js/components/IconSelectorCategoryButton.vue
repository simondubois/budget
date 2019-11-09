
<template>

    <button
        :class="{ 'btn-secondary': active }"
        class="w-auto btn"
        @click.prevent="internalValue = icon"
    >
        <fontawesome-icon :raw-icon="icon" />
    </button>

</template>



<script>

    export default {
        props: {
            icon: {
                type: String,
                required: true,
            },
            value: {
                type: String,
                required: true,
            },
        },
        computed: {
            active: vue => vue.icon === vue.internalValue,
            internalValue: {
                get: vue => vue.value,
                set(value) {
                    this.$emit('input', value);
                },
            },
        },
    };

</script>
