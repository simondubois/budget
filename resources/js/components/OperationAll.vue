
<template>

    <div class="container">

        <operation-filter class="d-none d-sm-flex" />

        <operation-list
            ref="operation-list"
            :account-id="accountId"
            :empty-text="$t('operation.all.empty')"
            :envelope-id="envelopeId"
            :limit="limit"
            :name="name"
            :types="types"
        >

            <template slot-scope="{ operationsByMonth }">
                <template v-for="(operationsInMonth, timestamp) in operationsByMonth">

                    <thead :key="'thead-' + timestamp">
                        <tr class="text-center">
                            <th
                                class="position-sticky bg-light text-muted border-0"
                                colspan="6"
                            >
                                <h2 class="mt-4">
                                    {{ formatMonth(timestamp) }}
                                </h2>
                            </th>
                        </tr>
                    </thead>

                    <transition-group
                        :key="'tbody-' + timestamp"
                        name="fade"
                        tag="tbody"
                        appear
                    >
                        <operation-show
                            v-for="operation in operationsInMonth"
                            :key="operation.id"
                            :operation="operation"
                            show-edit-button
                            show-envelope
                        />
                    </transition-group>

                </template>
            </template>

            <div
                slot="pagination"
                slot-scope="{ pagination }"
                class="mt-4 text-center text-muted"
            >

                <p class="small">
                    {{ $t('operation.all.paginationTitle', pagination) }}
                </p>

                <div v-if="pagination.total > pagination.per_page">

                    <button
                        class="btn btn-secondary btn-sm"
                        @click="limit += 100"
                    >
                        {{ $t('operation.all.paginationMore') }}
                    </button>

                    <button
                        class="btn btn-secondary btn-sm"
                        @click="limit = null"
                    >
                        {{ $t('operation.all.paginationAll') }}
                    </button>

                </div>

            </div>

        </operation-list>

        <transition
            mode="out-in"
            name="fade"
            appear
            @operation:refresh="refresh"
        >
            <router-view />
        </transition>

    </div>

</template>



<script>

    export default {
        data: () => ({
            limit: 100,
        }),
        computed: {
            accountId: vue => parseInt(vue.$route.query.filter_account_id) || null,
            envelopeId: vue => parseInt(vue.$route.query.filter_envelope_id) || null,
            name: vue => vue.$route.query.filter_name || null,
            typeValid: vue =>
                vue.rawTypes && Array.isArray(JSON.parse(vue.rawTypes)) && JSON.parse(vue.rawTypes).length,
            rawTypes: vue => vue.$route.query.filter_types,
            types: vue => vue.typeValid ? JSON.parse(vue.$route.query.filter_types) : null,
        },
        methods: {
            formatMonth: timestamp => require('moment')(parseInt(timestamp)).format('MMMM YYYY'),
            refresh() {
                this.$refs['operation-list'].refresh();
            },
        },
    };

</script>



<style scoped>

    .position-sticky {
        top: 0px;
        z-index: 1;
    }

</style>
