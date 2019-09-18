
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

        <li class="nav-item">
            <router-link
                :to="{ name: 'account-create' }"
                class="nav-link d-flex align-items-baseline"
            >

                <div class="flex-fill mr-1 text-truncate">
                    {{ $t('account.create.name') }}
                </div>

                <fontawesome-icon icon="create" />

            </router-link>
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
