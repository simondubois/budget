
<template>

    <span class="text-muted">

        <router-link
            v-if="originAccountId"
            :to="{ name: 'account-show', params: { accountId: originAccountId } }"
        >
            {{ originAccountName }}
        </router-link>

        <fontawesome-icon
            v-if="originAccountId && recipientAccountId"
            icon="next"
        />

        <router-link
            v-if="recipientAccountId"
            :to="{ name: 'account-show', params: { accountId: recipientAccountId } }"
        >
            {{ recipientAccountName }}
        </router-link>

    </span>

</template>



<script>

    export default {
        props: {
            originAccount: {
                type: Object,
                default: () => ({}),
            },
            recipientAccount: {
                type: Object,
                default: () => ({}),
            },
        },
        computed: {
            originAccountId: vue => vue.originAccount.id,
            originAccountName: vue => vue.originAccount.name,
            recipientAccountId: vue => vue.recipientAccount.id,
            recipientAccountName: vue => vue.recipientAccount.name,
        },
    };

</script>
