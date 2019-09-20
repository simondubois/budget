
<template>

    <form
        autocomplete="off"
        @submit.prevent="submit"
    >
        <bs-modal
            :close-route="closeRoute"
            :title="$t('envelope.create.name')"
            icon="create"
        >

            <div class="form-group">

                <label for="envelope-new-name">
                    {{ $t('envelope.attributes.name') }}
                </label>

                <input
                    id="envelope-new-name"
                    v-model="envelope.name"
                    :class="formControlClass('name')"
                    class="form-control"
                    type="text"
                    autofocus
                    required
                >

                <div
                    v-for="(error, index) in errors.name"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div class="form-group">

                <label for="envelope-new-default_allocation_amount">
                    {{ $t('envelope.attributes.defaultAllocation') }}
                </label>

                <div
                    :class="[
                        formControlClass('default_allocation_amount'),
                        formControlClass('default_allocation_currency_iso'),
                    ]"
                    class="input-group"
                >

                    <input
                        id="envelope-new-default_allocation_amount"
                        v-model="envelope.default_allocation_amount"
                        :class="formControlClass('default_allocation_amount')"
                        :placeholder="$t('envelope.attributes.defaultAllocationAmount')"
                        class="form-control text-right"
                        step="0.01"
                        type="number"
                        required
                    >

                    <currency-selector
                        v-model="envelope.default_allocation_currency_iso"
                        :class="formControlClass('default_allocation_currency_iso')"
                        :empty-option-text="$t('envelope.attributes.defaultAllocationCurrencyIso')"
                        class="custom-select"
                        required
                    />

                </div>

                <div
                    v-for="(error, index) in errors.default_allocation_amount"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

                <div
                    v-for="(error, index) in errors.default_allocation_currency_iso"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <div class="form-group">

                <label for="envelope-new-icon">
                    {{ $t('envelope.attributes.icon') }}
                </label>

                <icon-selector
                    id="envelope-new-icon"
                    v-model="envelope.icon"
                    :class="formControlClass('icon')"
                    :classes="formControlClass('icon')"
                    required
                />

                <div
                    v-for="(error, index) in errors.icon"
                    :key="index"
                    class="invalid-feedback"
                >
                    {{ error }}
                </div>

            </div>

            <button
                slot="footer-right"
                class="btn btn-primary"
                type="submit"
            >
                <fontawesome-icon icon="save" />
                {{ $t('actions.save') }}
            </button>

        </bs-modal>

    </form>

</template>



<script>

    export default {
        data: () => ({
            envelope: {
                default_allocation_currency_iso: '',
                icon: '',
                name: '',
            },
            errors: {},
        }),
        computed: {
            closeRoute: () => ({ name: 'envelope-all' }),
        },
        methods: {
            submit() {
                require('axios')
                    .post('api/envelopes', this.envelope)
                    .then(response => {
                        this.$store.dispatch('envelope/refresh');
                        this.$router.push({ name: 'envelope-show', params: { envelopeId: response.data.data.id } });
                    })
                    .catch(response => this.errors = response.response.data.errors);
            },
        },
    };

</script>
