
<template>

    <div class="input-group input-group-sm">

        <div class="d-sm-none input-group-append">
            <span
                :title="envelopeName"
                class="input-group-text bg-transparent border-0"
            >
                <fontawesome-icon :raw-icon="envelopeIcon" />
            </span>
        </div>

        <input
            v-model="internalAmount"
            :placeholder="$t('operation.attributes.amount')"
            class="form-control border-0 shadow-none text-right"
            step="0.01"
            type="number"
            required
        >

        <div class="input-group-append">

            <span class="input-group-text bg-transparent border-0">
                {{ currencyUnit }}
            </span>

            <button
                v-if="isDefaultCurrency"
                :class="{ active: isDefaultAmount === false }"
                :title="$t('envelope.attributes.defaultAllocation')"
                class="btn btn-outline-secondary"
                type="button"
                @click="internalAmount = defaultAmountNumber"
            >
                <fontawesome-icon :icon="isDefaultAmount ? 'valid' : 'restore'" />
            </button>

        </div>

    </div>

</template>



<script>

    export default {
        props: {
            allocation: {
                type: Object,
                required: true,
            },
        },
        computed: {
            amountNumber: vue => vue.allocation.amount.getNumber(vue.currency),
            currency: vue => vue.allocation.currency,
            currencyUnit: vue => vue.currency.unit,
            defaultAmount: vue => vue.makeMoney({ [vue.defaultCurrency.iso]: vue.envelope.default_allocation_amount }),
            defaultAmountNumber: vue => vue.defaultAmount.getNumber(vue.currency),
            defaultCurrency: vue => vue.envelope.default_allocation_currency,
            envelope: vue => vue.$store.getters['envelope/find'](vue.allocation.to_envelope_id),
            envelopeIcon: vue => vue.envelope.icon,
            envelopeName: vue => vue.envelope.name,
            internalAmount: {
                get: vue => vue.amountNumber,
                set(internalAmount) {
                    this.$emit('input', {
                        ...this.allocation,
                        amount: this.makeMoney({ [this.currency.iso]: parseFloat(internalAmount) }),
                    });
                },
            },
            isDefaultAmount: vue => vue.amountNumber === vue.defaultAmountNumber,
            isDefaultCurrency: vue => vue.currency.iso === vue.defaultCurrency.iso,
        },
        methods: {
            submit() {
                return require('axios')
                    .request({
                        method: this.allocation.id ? 'put' : 'post',
                        url: this.allocation.id ? 'api/operations/' + this.allocation.id : 'api/operations',
                        data: {
                            type: 'allocation',
                            to_envelope_id: this.envelope.id,
                            currency_iso: this.currency.iso,
                            amount: this.internalAmount,
                            date: this.allocation.date,
                        },
                    });
            },
        },
    };

</script>



<style scoped>

    .list-group-item {
        padding: 0.52rem 0.8rem;
        padding: 0.32rem 0.64rem;
    }

</style>