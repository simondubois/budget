
<template>

    <form
        autocomplete="off"
        @submit.prevent="submit"
    >
        <bs-modal
            :close-route="closeRoute"
            :title="$t('operation.edit.name')"
            icon="edit"
        >

            <div class="form-group">

                <operation-type-selector
                    v-model="operation.type"
                    :options="['expense', 'income', 'transfer']"
                    class="d-flex"
                    show-label
                />

                <div
                    v-for="(error, index) in errors.type"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div class="form-group">

                <label for="operation-new-name">
                    {{ $t('operation.attributes.name') }}
                </label>

                <input
                    id="operation-new-name"
                    v-model="operation.name"
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

                <label for="operation-new-date">
                    {{ $t('operation.attributes.date') }}
                </label>

                <input
                    id="operation-new-date"
                    v-model="operation.date"
                    :class="formControlClass('date')"
                    class="form-control"
                    type="date"
                    required
                >

                <div
                    v-for="(error, index) in errors.date"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div
                v-if="showFromAccountId"
                class="form-group"
            >

                <label for="operation-new-from_account_id">
                    {{ $t('operation.attributes.fromAccountId') }}
                </label>

                <account-selector
                    v-model="operation.from_account_id"
                    :class="formControlClass('from_account_id')"
                    required
                />

                <div
                    v-for="(error, index) in errors.from_account_id"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div
                v-if="showToAccountId"
                class="form-group"
            >

                <label for="operation-new-to_account_id">
                    {{ $t('operation.attributes.toAccountId') }}
                </label>

                <account-selector
                    v-model="operation.to_account_id"
                    :class="formControlClass('to_account_id')"
                    required
                />

                <div
                    v-for="(error, index) in errors.to_account_id"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div
                v-if="showFromEnvelopeId"
                class="form-group"
            >

                <label for="operation-new-from_envelope_id">
                    {{ $t('operation.attributes.fromEnvelopeId') }}
                </label>

                <envelope-selector
                    v-model="operation.from_envelope_id"
                    :class="formControlClass('from_envelope_id')"
                    required
                />

                <div
                    v-for="(error, index) in errors.from_envelope_id"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div
                v-if="showToEnvelopeId"
                class="form-group"
            >

                <label for="operation-new-to_envelope_id">
                    {{ $t('operation.attributes.toEnvelopeId') }}
                </label>

                <envelope-selector
                    v-model="operation.to_envelope_id"
                    :class="formControlClass('to_envelope_id')"
                    :empty-option-text="$t('operation.edit.emptyToEnvelopeId')"
                />

                <div
                    v-for="(error, index) in errors.to_envelope_id"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div class="form-group">

                <label for="operation-new-amount">
                    {{ $t('operation.attributes.amount') }}
                </label>

                <div class="input-group">

                    <input
                        id="operation-new-amount"
                        v-model="operation.amount"
                        :class="formControlClass('amount')"
                        class="form-control text-right"
                        step="0.01"
                        type="number"
                        required
                    >

                    <div
                        v-if="currency"
                        class="input-group-append"
                    >
                        <span class="input-group-text">
                            {{ currencyUnit }}
                        </span>
                    </div>

                    <div
                        v-for="(error, index) in errors.amount"
                        :key="index"
                        class="invalid-feedback"
                    >
                        {{ error }}
                    </div>

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
            operation: {
                type: '',
                from_account_id: '',
                to_account_id: '',
                from_envelope_id: '',
                to_envelope_id: '',
            },
            errors: {},
        }),
        computed: {
            account: vue => vue.$store.getters['account/find'](vue.operation.from_account_id || vue.operation.to_account_id),
            closeRoute: vue => ({ name: 'operation-all', query: vue.$route.query }),
            currency: vue => vue.account ? vue.account.currency : undefined,
            currencyUnit: vue => vue.currency ? vue.currency.unit : undefined,
            id: vue => parseInt(vue.$route.params.operationId),
            showFromAccountId: vue => vue.operation.type === 'expense' || vue.operation.type === 'transfer',
            showFromEnvelopeId: vue => vue.operation.type === 'expense',
            showToAccountId: vue => vue.operation.type === 'income' || vue.operation.type === 'transfer',
            showToEnvelopeId: vue => vue.operation.type === 'income',
        },
        watch: {
            id: {
                handler() {
                    require('axios')
                        .get('api/operations/' + this.id)
                        .then(response => this.operation = {
                            ...response.data.data,
                            amount: this.makeMoney(response.data.data.amount).getNumber(response.data.data.currency),
                            from_account_id: response.data.data.from_account_id || '',
                            from_envelope_id: response.data.data.from_envelope_id || '',
                            to_account_id: response.data.data.to_account_id || '',
                            to_envelope_id: response.data.data.to_envelope_id || '',
                        });
                },
                immediate: true,
            },
        },
        methods: {
            submit() {
                require('axios')
                    .put('api/operations/' + this.id, {
                        ...this.operation,
                        currency_iso: this.currency ? this.currency.iso : '',
                        from_account_id: this.showFromAccountId ? this.operation.from_account_id : null,
                        from_envelope_id: this.showFromEnvelopeId ? this.operation.from_envelope_id : null,
                        to_account_id: this.showToAccountId ? this.operation.to_account_id : null,
                        to_envelope_id: this.showToEnvelopeId ? this.operation.to_envelope_id : null,
                    })
                    .then(response => {
                        this.$store.dispatch('account/refresh');
                        this.$store.dispatch('accountHistory/updateStart', require('moment')(response.data.data.date));
                        this.$store.dispatch('envelope/refresh');
                        this.$store.dispatch('envelopeHistory/updateStart', require('moment')(response.data.data.date));
                        this.$emit('operation:refresh');
                        this.$router.push(this.closeRoute);
                    })
                    .catch(response => this.errors = response.response.data.errors);
            },
        },
    };

</script>
