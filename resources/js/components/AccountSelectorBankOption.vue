
<template>

    <option :value="id">
        {{ name }} ({{ currencyUnit }})
    </option>

</template>



<script>

    export default {
        props: {
            account: {
                type: Object,
                required: true,
            },
        },
        computed: {
            currencyUnit: vue => vue.account.currency.unit,
            id: vue => vue.account.id,
            name: vue => vue.account.name,
        },
    };

</script>
