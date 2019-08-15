
<template>

    <div class="list-group">

        <router-link
            :to="{ name: 'envelope-all' }"
            class="list-group-item list-group-item-action d-flex align-items-baseline font-weight-bold"
            exact
        >

            <span class="flex-fill mr-1 text-truncate">
                <fontawesome-icon icon="balance" />
                {{ $t('envelope.all.name') }}
            </span>

            <span
                :class="'badge-' + cumulatedBalanceContext"
                class="mr-1 badge"
            >
                {{ cumulatedBalanceText }}
            </span>

            <fontawesome-icon
                :class="'text-' + monthlyBalanceContext"
                :icon="monthlyBalanceIcon"
            />

        </router-link>

        <envelope-link
            v-for="envelope in envelopes"
            :key="envelope.id"
            :envelope="envelope"
            class="list-group-item list-group-item-action"
        />

        <slot name="footer" />

    </div>

</template>



<script>

    export default {
        computed: {
            cumulatedBalanceContext: vue => vue.$store.getters['envelope/cumulatedBalance'].getContext(vue.currency),
            cumulatedBalanceText: vue => vue.$store.getters['envelope/cumulatedBalance'].getText(vue.currency),
            currency: vue => vue.$store.getters['currency/selected'],
            envelopes: vue => vue.$store.getters['envelope/all'],
            monthlyBalanceContext: vue => vue.$store.getters['envelope/monthlyBalance'].getContext(vue.currency),
            monthlyBalanceIcon: vue => vue.$store.getters['envelope/monthlyBalance'].getIcon(vue.currency),
        },
    };

</script>
