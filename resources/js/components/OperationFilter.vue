
<template>

    <div class="row">

        <div class="col w-auto flex-fill form-group">
            <input
                v-model="name"
                :placeholder="$t('operation.attributes.name')"
                class="form-control"
                type="text"
            >
        </div>

        <div class="col w-auto flex-fill form-group">
            <account-selector
                v-model="accountId"
                :empty-option-text="$t('operation.filter.allAccounts')"
            />
        </div>

        <div class="col w-auto flex-fill form-group">
            <envelope-selector
                v-model="envelopeId"
                :empty-option-text="$t('operation.filter.allEnvelopes')"
            />
        </div>

        <div class="col w-auto form-group text-nowrap text-center">

            <operation-type-selector v-model="types" />

            <router-link
                :to="{ name: 'operation-all', query: { filter_types: JSON.stringify(['expense', 'income', 'transfer']) } }"
                class="btn btn-secondary ml-4"
                exact
                replace
            >
                <fontawesome-icon icon="reset" />
            </router-link>

        </div>

    </div>

</template>



<script>

    export default {
        computed: {
            accountId: {
                get: vue => vue.$route.query.filter_account_id || '',
                set(accountId) {
                    this.$router.replace({ name: 'operation-all', query: { ...this.query, filter_account_id: accountId }});
                },
            },
            envelopeId: {
                get: vue => vue.$route.query.filter_envelope_id || '',
                set(envelopeId) {
                    this.$router.replace({ name: 'operation-all', query: { ...this.query, filter_envelope_id: envelopeId }});
                },
            },
            name: {
                get: vue => vue.$route.query.filter_name || '',
                set(name) {
                    this.$router.replace({ name: 'operation-all', query: { ...this.query, filter_name: name }});
                },
            },
            query: vue => ({
                filter_account_id: vue.accountId,
                filter_envelope_id: vue.envelopeId,
                filter_name: vue.name,
                filter_types: JSON.stringify(vue.types),
            }),
            rawTypes: vue => vue.$route.query.filter_types,
            types: {
                get: vue =>  vue.typeValid ? JSON.parse(vue.rawTypes) : Object.keys(vue.$t('operation.types')),
                set(types) {
                    this.$router.replace({
                        name: 'operation-all',
                        query: { ...this.query, filter_types: JSON.stringify(types) },
                    });
                },
            },
            typeValid: vue =>
                vue.rawTypes && Array.isArray(JSON.parse(vue.rawTypes)) && JSON.parse(vue.rawTypes).length,
        },
    };

</script>
