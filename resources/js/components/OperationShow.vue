
<template>

    <tr>

        <td
            class="d-sm-none align-middle"
            colspan="3"
        >

            <div>
                {{ name }}
            </div>

            <div class="text-muted">
                {{ date }}
            </div>

            <div
                v-if="envelope"
                class="text-muted"
            >
                <operation-show-envelope :envelope="envelope" />
            </div>

            <div
                v-if="originAccount || recipientAccount"
                class="text-muted"
            >
                <operation-show-account
                    :origin-account="originAccount"
                    :recipient-account="recipientAccount"
                />
            </div>

        </td>

        <td class="d-none d-sm-table-cell align-middle">
            <operation-show-account
                v-if="originAccount || recipientAccount"
                :origin-account="originAccount"
                :recipient-account="recipientAccount"
            />
        </td>

        <td
            class="d-none d-sm-table-cell align-middle"
        >
            <operation-show-envelope
                v-if="envelope"
                :envelope="envelope"
            />
        </td>

        <td class="d-none d-sm-table-cell align-middle">

            {{ name }}

            <span class="text-muted">
                - {{ date }}
            </span>

        </td>

        <td class="align-middle text-right">
            {{ amount }}
        </td>

        <td class="align-middle">
            <fontawesome-icon
                :class="iconClass"
                :icon="type"
                :title="$t('operation.types.' + type)"
            />
        </td>

        <td
            v-if="showEditButton"
            class="align-middle"
        >
            <div class="btn-group">

                <router-link
                    v-if="duplicateRoute"
                    :title="$t('operation.duplicate.name')"
                    :to="duplicateRoute"
                    class="btn btn-primary btn-sm"
                >
                    <fontawesome-icon icon="duplicate" />
                </router-link>

                <router-link
                    v-if="editRoute"
                    :title="$t('operation.edit.name')"
                    :to="editRoute"
                    class="btn btn-primary btn-sm"
                >
                    <fontawesome-icon icon="edit" />
                </router-link>

            </div>
        </td>

    </tr>

</template>



<script>

    export default {
        props: {
            operation: {
                type: Object,
                required: true,
            },
            showEnvelope: {
                type: Boolean,
                default: false,
            },
            showEditButton: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            amount: vue => {
                if (vue.type === 'expense') {
                    return vue.operation.amount.makeOpposite().getText(vue.currency);
                }
                return vue.operation.amount.getText(vue.currency);
            },
            currency: vue => vue.operation.currency,
            date: vue => vue.operation.date.format('L'),
            duplicateRoute: vue => vue.type === 'allocation' ? null : ({
                name: 'operation-create',
                query: {
                    ...vue.$route.query,
                    create_type: vue.operation.type,
                    create_from_account_id: vue.operation.from_account_id,
                    create_to_account_id: vue.operation.to_account_id,
                    create_from_envelope_id: vue.operation.from_envelope_id,
                    create_to_envelope_id: vue.operation.to_envelope_id,
                    create_name: vue.operation.name,
                    create_amount: vue.operation.amount.getNumber(vue.currency),
                    create_currency: vue.currency,
                },
            }),
            editRoute: vue => vue.type === 'allocation' ? null : ({
                name: 'operation-edit',
                params: { operationId: vue.operation.id },
                query: vue.$route.query,
            }),
            envelope: vue =>  vue.showEnvelope ? vue.originEnvelope || vue.recipientEnvelope : null,
            iconClass: vue => ({
                'text-danger': vue.type === 'expense',
                'text-info': vue.type === 'allocation',
                'text-success': vue.type === 'income',
                'text-warning': vue.type === 'transfer',
            }),
            name: vue => vue.type === 'allocation' ? vue.$t('operation.types.allocation') : vue.operation.name,
            originAccount: vue => vue.$store.getters['account/find'](vue.operation.from_account_id),
            originEnvelope: vue => vue.$store.getters['envelope/find'](vue.operation.from_envelope_id),
            recipientAccount: vue => vue.$store.getters['account/find'](vue.operation.to_account_id),
            recipientEnvelope: vue => vue.$store.getters['envelope/find'](vue.operation.to_envelope_id),
            type: vue => vue.operation.type,
        },
    };

</script>
