
<template>

    <div>

        <bs-card>
            <router-link
                slot="list"
                :to="{ name: 'account-all' }"
                class="list-group-item list-group-item-action d-flex align-items-baseline"
                exact
            >

                <div class="flex-fill mr-1 text-truncate">
                    {{ $t('account.all.name') }}
                </div>

                <fontawesome-icon icon="balance" />

            </router-link>
        </bs-card>

        <account-list-bank
            v-for="bank in banks"
            :key="bank"
            :bank="bank"
            class="mt-3"
        />

        <bs-card class="mt-3">
            <router-link
                slot="list"
                :to="{ name: 'account-create' }"
                class="list-group-item list-group-item-action d-flex align-items-baseline"
            >

                <div class="flex-fill mr-1 text-truncate">
                    {{ $t('account.create.name') }}
                </div>

                <fontawesome-icon icon="create" />

            </router-link>
        </bs-card>
    </div>

</template>



<script>

    export default {
        computed: {
            banks: vue => vue.$store.getters['account/banks'],
        },
    };

</script>
