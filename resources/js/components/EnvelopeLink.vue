
<template>

    <router-link
        :to="{ name: 'envelope-show', params: { envelopeId: id } }"
        class="d-flex align-items-baseline"
    >

        <span class="flex-fill mr-1 text-truncate">
            <fontawesome-icon :raw-icon="icon" />
            {{ name }}
        </span>

        <span
            :class="'badge-' + cumulatedBalanceContext"
            class="badge mr-1"
        >
            {{ cumulatedBalanceText }}
        </span>

        <fontawesome-icon
            :class="'text-' + monthlyBalanceContext"
            :icon="monthlyBalanceIcon"
        />

    </router-link>

</template>



<script>

    export default {
        props: {
            envelope: {
                type: Object,
                required: true,
            },
        },
        computed: {
            cumulatedBalanceContext: vue => vue.envelope.cumulatedBalance.getContext(vue.currency),
            cumulatedBalanceText: vue => vue.envelope.cumulatedBalance.getText(vue.currency),
            currency: vue => vue.$store.getters['currency/selected'],
            icon: vue => vue.envelope.icon,
            id: vue => vue.envelope.id,
            monthlyBalanceContext: vue => vue.envelope.monthlyBalance.getContext(vue.currency),
            monthlyBalanceIcon: vue => vue.envelope.monthlyBalance.getIcon(vue.currency),
            name: vue => vue.envelope.name,
        },
    };

</script>
