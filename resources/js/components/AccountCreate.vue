
<template>

    <form
        autocomplete="off"
        @submit.prevent="submit"
    >
        <bs-modal
            :close-route="closeRoute"
            :title="$t('account.create.name')"
            icon="create"
        >

            <div class="form-group">

                <label for="account-new-name">
                    {{ $t('account.attributes.name') }}
                </label>

                <input
                    id="account-new-name"
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

                <label for="account-new-currency_iso">
                    {{ $t('account.attributes.currencyIso') }}
                </label>

                <currency-selector
                    id="account-new-currency_iso"
                    v-model="account.currency_iso"
                    :class="formControlClass('currency_iso')"
                    required
                    show-name
                />

                <div
                    v-for="(error, index) in errors.currency_iso"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div class="form-group">

                <label for="account-new-bank">
                    {{ $t('account.attributes.bank') }}
                </label>

                <input
                    id="account-new-bank"
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
            account: {
                bank: '',
                currency_iso: '',
                name: '',
            },
            errors: {},
        }),
        computed: {
            banks: vue => vue.$store.getters['account/banks'],
            closeRoute: () => ({ name: 'account-all' }),
        },
        methods: {
            submit() {
                require('axios')
                    .post('api/accounts', this.account)
                    .then(response => {
                        this.$store.dispatch('account/refresh');
                        this.$router.push({ name: 'account-show', params: { accountId: response.data.data.id } });
                    })
                    .catch(response => this.errors = response.response.data.errors);
            },
        },
    };

</script>
