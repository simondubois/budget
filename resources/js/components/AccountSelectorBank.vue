
<template>

    <optgroup :label="bank">
        <account-selector-bank-option
            v-for="account in accounts"
            :key="account.id"
            :account="account"
        />
    </optgroup>

</template>



<script>

    export default {
        props: {
            bank: {
                type: String,
                required: true,
            },
        },
        computed: {
            accounts: vue => vue.$store.getters['account/whereBank'](vue.bank),
        },
    };

</script>
