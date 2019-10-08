
<template>

    <div class="btn-group btn-group-toggle">
        <operation-type-selector-button
            v-for="type in types"
            :key="type"
            :checked="selected[type]"
            :context="contextes[type]"
            :disabled="disabled[type]"
            :multiple="multiple"
            :name="type"
            :show-label="showLabel"
            @check="select(type)"
            @uncheck="unselect(type)"
        />
    </div>

</template>



<script>

    export default {
        props: {
            types: {
                type: Array,
                default: () => (['expense', 'income', 'transfer', 'allocation']),
            },
            showLabel: {
                type: Boolean,
                default: false,
            },
            value: {
                type: [Array, String],
                required: true,
            },
        },
        computed: {
            contextes: () => ({
                expense: 'danger',
                income: 'success',
                transfer: 'warning',
                allocation: 'info',
            }),
            disabled: vue => ({
                expense: vue.multiple && vue.value.length === 1 && vue.selected.expense,
                income: vue.multiple && vue.value.length === 1 && vue.selected.income,
                transfer: vue.multiple && vue.value.length === 1 && vue.selected.transfer,
                allocation: vue.multiple && vue.value.length === 1 && vue.selected.allocation,
            }),
            multiple: vue => vue.value instanceof Array,
            selected: vue => ({
                expense: vue.multiple ? vue.value.includes('expense') : vue.value === 'expense',
                income: vue.multiple ? vue.value.includes('income') : vue.value === 'income',
                transfer: vue.multiple ? vue.value.includes('transfer') : vue.value === 'transfer',
                allocation: vue.multiple ? vue.value.includes('allocation') : vue.value === 'allocation',
            }),
        },
        methods: {
            select(type) {
                if (this.multiple) {
                    return this.$emit('input', [...this.value, type]);
                }
                this.$emit('input', type);
            },
            unselect(type) {
                if (this.multiple) {
                    return this.$emit('input', this.value.filter(t => t !== type));
                }
            },
        },
    };

</script>
