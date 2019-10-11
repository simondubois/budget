
<template>

    <div class="d-flex overflow-auto mr-3">

        <div class="d-none d-sm-block position-sticky pl-3 mr-3 bg-white">
            <envelope-list class="list-group-flush" />
        </div>

        <div
            v-for="(allocation, index) in allocationsByMonth"
            :key="index"
            class="ml-3"
        >
            <allocation-month
                :allocations="allocationsByMonth[index]"
                :date="months[index]"
                :previous-allocations="allocationsByMonth[index + 1]"
                @input="$set(allocationsByMonth, index, $event)"
                @refresh:allocations="refresh"
            />
        </div>

    </div>

</template>



<script>

    export default {
        data: () => ({
            allocationsByMonth: [],
        }),
        computed: {
            minMonth: vue => require('moment')(vue.startDate).startOf('month'),
            maxMonth: vue => require('moment')().startOf('month'),
            months: vue => new Array(vue.maxMonth.diff(vue.minMonth, 'month') + 1)
                .fill(undefined)
                .map((value, index) => vue.maxMonth.clone().subtract(index, 'month')),
            startDate: () => document.head.querySelector("[name=start-date]").content,
        },
        created() {
            this.refresh();
        },
        methods: {
            refresh() {
                require('axios')
                    .get('api/operations', { params: { types: ['allocation'] } })
                    .then(response => {
                        this.allocationsByMonth = this.months.map(month =>
                            response.data.data
                                .filter(allocation => allocation.date === month.format('YYYY-MM-DD'))
                                .map(allocation => ({
                                    ...allocation,
                                    amount: this.makeMoney(allocation.amount),
                                    initial_amount: this.makeMoney(allocation.amount),
                                }))
                        );
                    });
            },
        },
    };

</script>



<style scoped>

    .position-sticky {
        left: 0px;
        z-index: 3;
        max-width: 200px;
    }

    .list-group {
        min-width: 150px;
    }

</style>
