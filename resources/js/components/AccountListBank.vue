
<template>

    <bs-card>

        <div
            slot="header"
            class="text-center small text-muted"
        >
            {{ bank }}
        </div>

        <template slot="list">
            <account-link
                v-for="account in accounts"
                :key="account.id"
                :account="account"
                class="list-group-item list-group-item-action"
            />
        </template>

    </bs-card>

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
