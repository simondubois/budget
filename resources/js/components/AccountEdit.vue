
<template>

    <form
        autocomplete="off"
        @submit.prevent="submit"
    >
        <bs-modal
            :close-route="closeRoute"
            :title="$t('account.edit.name')"
            icon="edit"
        >

            <div class="form-group">

                <label for="account-edit-name">
                    {{ $t('account.attributes.name') }}
                </label>

                <input
                    id="account-edit-name"
                    v-model="account.name"
                    :class="formControlClass('name')"
                    class="form-control"
                    type="text"
                    autofocus
                    required
                >

                <div
                    v-for="(error, index) in errors.name"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div class="form-group">

                <label for="account-edit-currency_iso">
                    {{ $t('account.attributes.currencyIso') }}
                </label>

                <input
                    id="account-edit-currency_iso"
                    :class="formControlClass('currency_iso')"
                    :value="account.currency.name + ' (' + account.currency.unit + ')'"
                    class="form-control"
                    type="text"
                    disabled
                >

                <div
                    v-for="(error, index) in errors.currency_iso"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div class="form-group">

                <label for="account-edit-bank">
                    {{ $t('account.attributes.bank') }}
                </label>

                <input
                    id="account-edit-bank"
                    v-model="account.bank"
                    :class="formControlClass('bank')"
                    class="form-control"
                    list="account-new-bank-list"
                    type="text"
                    required
                >

                <datalist id="account-new-bank-list">
                    <option
                        v-for="bank in banks"
                        :key="bank"
                    >
                        {{ bank }}
                    </option>
                </datalist>

                <div
                    v-for="(error, index) in errors.bank"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <button
                slot="footer-right"
                class="btn btn-primary"
                type="submit"
            >
                <fontawesome-icon icon="save" />
                {{ $t('actions.save') }}
            </button>

        </bs-modal>
    </form>

</template>



<script>

    export default {
        data: () => ({
            account: {},
            errors: {},
        }),
        computed: {
            banks: vue => vue.$store.getters['account/banks'],
            closeRoute: vue => ({ name: 'account-show', params: { accountId: vue.id } }),
            id: vue => parseInt(vue.$route.params.accountId),
            originalAccount: vue => vue.$store.getters['account/find'](vue.id) || { currency: {} },
        },
        watch: {
            originalAccount: {
                handler() {
                    this.account = this.originalAccount;
                },
                immediate: true,
            },
        },
        methods: {
            submit() {
                require('axios')
                    .put('api/accounts/' + this.id, this.account)
                    .then(() => {
                        this.$store.dispatch('account/refresh');
                        this.$router.push(this.closeRoute);
                    })
                    .catch(response => this.errors = response.response.data.errors);
            },
        },
    };

</script>
