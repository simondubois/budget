
<template>

    <router-link
        :to="{ name: 'account-show', params: { accountId: id } }"
        class="d-flex align-items-baseline"
    >

        <div class="flex-fill mr-1 text-truncate">
            {{ name }}
        </div>

        <div class="badge badge-dark">
            {{ currencyUnit }}
        </div>

    </router-link>

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
