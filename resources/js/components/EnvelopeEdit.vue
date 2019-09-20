
<template>

    <form
        autocomplete="off"
        @submit.prevent="submit"
    >
        <bs-modal
            :close-route="closeRoute"
            :title="$t('envelope.edit.name')"
            icon="edit"
        >

            <div class="form-group">

                <label for="envelope-edit-name">
                    {{ $t('envelope.attributes.name') }}
                </label>

                <input
                    id="envelope-edit-name"
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

                <label for="envelope-edit-default_allocation_amount">
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
                        id="envelope-edit-default_allocation_amount"
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

                <label for="envelope-edit-icon">
                    {{ $t('envelope.attributes.icon') }}
                </label>

                <icon-selector
                    id="envelope-edit-icon"
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
            envelope: {},
            errors: {},
        }),
        computed: {
            closeRoute: vue => ({ name: 'envelope-show', params: { envelopeId: vue.id } }),
            id: vue => parseInt(vue.$route.params.envelopeId),
            originalEnvelope: vue => vue.$store.getters['envelope/find'](vue.id) || {
                default_allocation_currency: {
                    iso: '',
                },
                icon: '',
            },
        },
        watch: {
            originalEnvelope: {
                handler() {
                    this.envelope = this.originalEnvelope;
                    this.envelope.default_allocation_currency_iso = this.envelope.default_allocation_currency.iso;
                },
                immediate: true,
            },
        },
        methods: {
            submit() {
                require('axios')
                    .put('api/envelopes/' + this.id, this.envelope)
                    .then(() => {
                        this.$store.dispatch('envelope/refresh');
                        this.$router.push(this.closeRoute);
                    })
                    .catch(response => this.errors = response.response.data.errors);
            },
        },
    };

</script>
