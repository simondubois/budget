
<template>

    <div>

        <h6 class="dropdown-header">
            {{ $t('icons.categories.' + category) }}
        </h6>

        <icon-selector-category-button
            v-for="icon in icons"
            :key="icon"
            v-model="internalValue"
            :icon="'fa-' + icon"
        />

    </div>

</template>



<script>

    export default {
        props: {
            category: {
                type: String,
                required: true,
            },
            icons: {
                type: Array,
                required: true,
            },
            value: {
                type: String,
                required: true,
            },
        },
        computed: {
            internalValue: {
                get: vue => vue.value,
                set(value) {
                    this.$emit('input', value);
                },
            },
        },
    };

</script>
