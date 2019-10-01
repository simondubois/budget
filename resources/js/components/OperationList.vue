
<template>

    <div
        v-if="empty"
        class="alert alert-info text-center font-weight-bold"
    >
        {{ emptyText }}
    </div>

    <div v-else>

        <transition-group
            class="table table-sm table-striped"
            name="fade"
            tag="table"
            appear
        >
            <slot
                :operations="operations"
                :operationsByMonth="operationsByMonth"
            />
        </transition-group>

        <slot
            v-if="limit"
            :pagination="pagination"
            name="pagination"
        />

    </div>

</template>



<script>

    export default {
        props: {
            accountId: {
                type: Number,
                default: null,
            },
            envelopeId: {
                type: Number,
                default: null,
            },
            emptyText: {
                type: String,
                required: true,
            },
            limit: {
                type: Number,
                default: null,
            },
            minDate: {
                type: String,
                default: null,
            },
            name: {
                type: String,
                default: null,
            },
            types: {
                type: Array,
                default: null,
            },
        },
        data: () => ({
            operations: [],
            pagination: {},
            requestId: '',
        }),
        computed: {
            empty: vue => vue.operations.length === 0,
            filters: vue => ({
                account_id: vue.accountId,
                envelope_id: vue.envelopeId,
                min_date: vue.minDate,
                name: vue.name,
                per_page: vue.limit,
                types: vue.types,
            }),
            operationsByMonth: vue => vue.operations.reduce((operationsByMonth, operation) => {
                const timestamp = operation.date.clone().startOf('month').valueOf();
                if (operationsByMonth[timestamp] === undefined) {
                    operationsByMonth[timestamp] = [];
                }
                operationsByMonth[timestamp].push(operation)
                return operationsByMonth;
            }, {}),
        },
        watch: {
            filters: {
                handler() {
                    this.refresh();
                },
                immediate: true,
            },
        },
        methods: {
            refresh() {
                this.requestId = JSON.stringify(this.filters);
                require('axios')
                    .get('api/operations', { params: this.filters })
                    .then(response =>
                        JSON.stringify(response.config.params) === this.requestId ?
                            response : Promise.reject('Concurrent request canceled.')
                    )
                    .then(response => {
                        this.operations = response.data.data.map(operation => ({
                            ...operation,
                            amount: this.makeMoney(operation.amount),
                            date: require('moment')(operation.date),
                        }));
                        this.pagination = response.data.meta;
                    });
            },
        },
    };

</script>
