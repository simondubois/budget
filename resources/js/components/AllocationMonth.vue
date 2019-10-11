
<template>

    <div class="list-group list-group-flush">

        <div class="list-group-item list-group-item-action">
            <div class="d-flex align-items-baseline">

                <div class="mr-1 font-weight-bold text-truncate">
                    {{ month }}
                </div>

                <div class="flex-fill text-right">

                    <button
                        v-if="edited"
                        :title="$t('actions.save')"
                        class="btn btn-primary btn-sm"
                        type="button"
                        @click="submit"
                    >
                        <fontawesome-icon icon="save" />
                    </button>

                    <currency-selector
                        v-else
                        v-model="currencyIso"
                        class="form-control-sm w-auto ml-auto"
                        required
                    />

                </div>

            </div>
        </div>

        <allocation-envelope
            v-for="(envelope, index) in envelopes"
            ref="allocation-envelope"
            :key="envelope.id"
            :allocation="allocationsByEnvelope[index]"
            :previous-allocation="previousAllocationsByEnvelope[index]"
            @input="$emit('input', allocationsByEnvelope.map((allocation, key) => key === index ? $event : allocation))"
        />

        <div
            v-if="currency"
            class="list-group-item list-group-item-action pr-5"
        >
            <input
                :value="totalText"
                class="form-control-sm border-0 bg-transparent shadow-none text-right text-dark font-weight-bold"
                readonly
            >
            <allocation-variation
                :currency="currency"
                :variation="totalVariation"
            />
        </div>

    </div>

</template>



<script>

    export default {
        props: {
            allocations: {
                type: Array,
                required: true,
            },
            date: {
                type: Object,
                required: true,
            },
            previousAllocations: {
                type: Array,
                default: () => [],
            },
        },
        data: vue => ({
            currencyIso: vue.allocations.length ?
                vue.allocations[0].currency.iso : vue.$store.getters['currency/selected'].iso,
        }),
        computed: {
            allocationsByEnvelope: vue => vue.envelopes.map(envelope => ({
                amount: vue.makeMoney(),
                date: vue.date.format('YYYY-MM-DD'),
                initial_amount: vue.makeMoney(),
                to_envelope_id: envelope.id,
                type: 'allocation',
                ...vue.allocations.find(allocation => allocation.to_envelope_id === envelope.id),
                currency: vue.currency,
            })),
            currency: vue => vue.$store.getters['currency/find'](vue.currencyIso),
            edited: vue => vue.allocations.some(
                allocation =>
                    allocation.initial_amount.getNumber(vue.currency) !== allocation.amount.getNumber(vue.currency)
            ),
            envelopes: vue => vue.$store.getters['envelope/all'],
            month: vue => vue.date.format('MMMM YYYY'),
            previousAllocationsByEnvelope: vue => vue.envelopes.map(envelope =>
                vue.previousAllocations.find(allocation => allocation.to_envelope_id === envelope.id)
            ),
            previousTotal: vue =>  vue.previousAllocations.reduce(
                (total, allocation) => total.add(allocation.amount), vue.makeMoney()
            ),
            total: vue =>  vue.allocations.reduce((total, allocation) => total.add(allocation.amount), vue.makeMoney()),
            totalText: vue =>  vue.total.getText(vue.currency),
            totalVariation: vue => vue.total.subtract(vue.previousTotal),
        },
        methods: {
            submit() {
                this.$refs['allocation-envelope']
                    .reduce((promise, component) => promise.then(component.submit), Promise.resolve())
                    .then(() => {
                        this.$store.dispatch('account/refresh');
                        this.$store.dispatch('envelope/refresh');
                        this.$emit('refresh:allocations');
                    });
            },
        },
    };

</script>



<style scoped>

    .list-group-item {
        padding-top: 0.52rem;
        padding-bottom: 0.52rem;
    }

</style>
