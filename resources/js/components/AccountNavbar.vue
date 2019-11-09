
<template>

    <ul class="navbar-nav">

        <li class="nav-item">
            <router-link
                :to="{ name: 'account-all' }"
                class="nav-link"
                exact
            >
                {{ $t('account.all.name') }}
            </router-link>
        </li>

        <li
            v-for="account in accounts"
            :key="account.id"
            class="nav-item"
        >
            <account-link
                :account="account"
                class="nav-link"
            />
        </li>

    </ul>

</template>



<script>

    export default {
        computed: {
            accounts: vue => vue.$store.getters['account/all'],
        },
    };

</script>
