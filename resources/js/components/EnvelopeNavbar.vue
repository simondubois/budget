
<template>

    <ul class="navbar-nav">

        <li class="nav-item">
            <router-link
                :to="{ name: 'envelope-all' }"
                class="nav-link d-flex align-items-baseline"
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
        </li>

        <li
            v-for="envelope in envelopes"
            :key="envelope.id"
            class="nav-item"
        >
            <envelope-link
                :envelope="envelope"
                class="nav-link"
            />
        </li>

        <li class="nav-item">
            <router-link
                :to="{ name: 'envelope-create' }"
                class="nav-link d-flex align-items-baseline"
            >

                <div class="flex-fill mr-1 text-truncate">
                    {{ $t('envelope.create.name') }}
                </div>

                <fontawesome-icon icon="create" />

            </router-link>
        </li>

    </ul>

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
