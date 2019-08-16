
<template>

    <div class="list-group list-group-flush">

        <div class="list-group-item d-flex align-items-baseline">

            <span class="flex-fill text-truncate mr-1 text-muted">
                <fontawesome-icon icon="balance" />
                {{ $t('envelope.attributes.cumulatedBalance') }} {{ previousMonth }}
            </span>

            <span
                :class="'badge-' + previousCumulatedBalanceContext"
                class="badge"
            >
                {{ previousCumulatedBalanceText }}
            </span>

        </div>

        <div class="list-group-item d-flex align-items-baseline">

            <span class="flex-fill text-truncate mr-1 text-success">
                <fontawesome-icon icon="allocation" />
                {{ $t('envelope.attributes.allocations') }} {{ currentMonth }}
            </span>

            <span
                :class="'badge-' + monthlyAllocationsContext"
                class="badge"
            >
                {{ monthlyAllocationsText }}
            </span>

        </div>

        <div class="list-group-item d-flex align-items-baseline">

            <span class="flex-fill text-truncate mr-1 text-danger">
                <fontawesome-icon icon="expense" />
                {{ $t('envelope.attributes.expenses') }} {{ currentMonth }}
            </span>

            <span
                :class="'badge-' + oppositeMonthlyExpensesContext"
                class="badge"
            >
                {{ oppositeMonthlyExpensesText }}
            </span>

        </div>

        <div class="list-group-item d-flex align-items-baseline">

            <span class="flex-fill text-truncate mr-1 text-success">
                <fontawesome-icon icon="income" />
                {{ $t('envelope.attributes.incomes') }} {{ currentMonth }}
            </span>

            <span
                :class="'badge-' + monthlyIncomesContext"
                class="badge"
            >
                {{ monthlyIncomesText }}
            </span>

        </div>

        <div class="list-group-item d-flex align-items-baseline">

            <span class="flex-fill text-truncate mr-1 text-muted">
                <fontawesome-icon icon="balance" />
                {{ $t('envelope.attributes.cumulatedBalance') }} {{ currentMonth }}
            </span>

            <span
                :class="'badge-' + cumulatedBalanceContext"
                class="badge"
            >
                {{ cumulatedBalanceText }}
            </span>

        </div>

    </div>

</template>



<script>

    export default {
        props: {
            cumulatedBalance: {
                type: Object,
                required: true,
            },
            monthlyAllocations: {
                type: Object,
                required: true,
            },
            monthlyExpenses: {
                type: Object,
                required: true,
            },
            monthlyIncomes: {
                type: Object,
                required: true,
            },
            previousCumulatedBalance: {
                type: Object,
                required: true,
            },
        },
        computed: {
            cumulatedBalanceContext: vue => vue.cumulatedBalance.getContext(vue.currency),
            cumulatedBalanceText: vue => vue.cumulatedBalance.getText(vue.currency),
            currency: vue => vue.$store.getters['currency/selected'],
            currentMonth: () => require('moment')().format('MMMM YYYY'),
            monthlyAllocationsContext: vue => vue.monthlyAllocations.getContext(vue.currency),
            monthlyAllocationsText: vue => vue.monthlyAllocations.getText(vue.currency),
            monthlyIncomesContext: vue => vue.monthlyIncomes.getContext(vue.currency),
            monthlyIncomesText: vue => vue.monthlyIncomes.getText(vue.currency),
            oppositeMonthlyExpenses: vue => vue.monthlyExpenses.makeOpposite(),
            oppositeMonthlyExpensesContext: vue => vue.oppositeMonthlyExpenses.getContext(vue.currency),
            oppositeMonthlyExpensesText: vue => vue.oppositeMonthlyExpenses.getText(vue.currency),
            previousCumulatedBalanceContext: vue => vue.previousCumulatedBalance.getContext(vue.currency),
            previousCumulatedBalanceText: vue => vue.previousCumulatedBalance.getText(vue.currency),
            previousMonth: () => require('moment')().subtract(1, 'month').format('MMMM YYYY'),
        },
    };

</script>
