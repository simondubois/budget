
<template>

    <div
        :class="{ 'list-group-item-warning': edited }"
        class="list-group-item list-group-item-action"
    >

        <allocation-edit
            ref="allocation-edit"
            :allocation="allocation"
            @input="$emit('input', $event)"
        />

        <allocation-variation
            :currency="currency"
            :variation="variation"
        />

    </div>

</template>



<script>

    export default {
        props: {
            allocation: {
                type: Object,
                required: true,
            },
            previousAllocation: {
                type: Object,
                default: () => ({}),
            },
        },
        computed: {
            amountNumber: vue => vue.allocation.amount.getNumber(vue.currency),
            currency: vue => vue.allocation.currency,
            edited: vue => vue.initialAmountNumber !== vue.amountNumber,
            initialAmountNumber: vue => vue.allocation.initial_amount.getNumber(vue.currency),
            variation: vue => vue.allocation.amount.subtract(vue.previousAllocation.amount || vue.makeMoney()),
        },
        methods: {
            submit() {
                return this.edited ? this.$refs['allocation-edit'].submit() : Promise.resolve();
            },
        },
    };

</script>
