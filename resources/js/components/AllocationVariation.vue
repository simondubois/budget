
<template>

    <div
        v-if="number"
        :class="'badge-' + context"
        class="position-absolute badge"
    >

        <div>
            {{ numberText }}
        </div>

        <div>
            {{ currencyText }}
        </div>

    </div>

</template>



<script>

    export default {
        props: {
            currency: {
                type: Object,
                required: true,
            },
            variation: {
                type: Object,
                required: true,
            },
        },
        computed: {
            context: vue => vue.variation.getContext(vue.currency),
            currencyText: vue => vue.text.split(' ')[1],
            number: vue => vue.variation.getNumber(vue.currency),
            numberText: vue => vue.text.split(' ')[0],
            text: vue => vue.variation.getText(vue.currency),
        },
    };

</script>



<style scoped>

    .position-absolute {
        top: 50%;
        right: 0px;
        transform: translate(calc(50% + 0.5rem), -50%);
        z-index: 2;
    }

</style>
