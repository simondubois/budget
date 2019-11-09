
<template>

    <li
        class="nav-item"
        :class="{ active: selected }"
    >
        <a
            class="nav-link"
            href=""
            @click.prevent="select"
        >
            {{ unit }}
        </a>
    </li>

</template>



<script>

    export default {
        props: {
            currency: {
                type: Object,
                required: true,
            },
        },
        computed: {
            selected: vue => vue.currency.iso === vue.$store.getters['currency/selected'].iso,
            unit: vue => vue.currency.unit,
        },
        methods: {
            select() {
                this.$store.dispatch('currency/select', this.currency);
            },
        },
    };

</script>
