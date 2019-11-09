<template>

    <nav class="navbar navbar-dark bg-dark">

        <div class="navbar-expand flex-grow-1">

            <ul class="navbar-nav">

                <li
                    :class="{ invisible: !$slots.default }"
                    class="nav-item"
                >
                    <a
                        class="nav-link d-sm-none"
                        href
                        @click.prevent="collapse = !collapse"
                    >
                        <fontawesome-icon icon="menu" />
                    </a>
                </li>

                <li class="nav-item">
                    <router-link
                        :to="{ name: 'account-all' }"
                        class="nav-link"
                    >
                        <fontawesome-icon icon="account" />
                        <span class="d-none d-sm-inline">
                            {{ $t('account.name') }}
                        </span>
                    </router-link>
                </li>

                <li class="nav-item flex-grow-1" />

                <li
                    v-if="loading"
                    class="nav-item"
                >
                    <a class="nav-link">
                        <fontawesome-icon
                            icon="sync"
                            class="text-info"
                            spin
                        />
                    </a>
                </li>

                <bs-navbar-currency
                    v-for="currency in currencies"
                    :key="currency.iso"
                    :currency="currency"
                />

            </ul>

        </div>

        <div
            :class="{ 'show': !collapse }"
            class="navbar-collapse collapse d-sm-none"
        >
            <slot />
        </div>

    </nav>

</template>



<script>

    export default {
        data: () => ({
            collapse: true,
        }),
        computed: {
            currencies: vue => vue.$route.meta.showCurrencySelector ? vue.$store.getters['currency/all'] : [],
            loading: vue => vue.$store.getters['state/loading'],
        },
        watch: {
            $route() {
                this.collapse = true;
            },
        },
    };

</script>
