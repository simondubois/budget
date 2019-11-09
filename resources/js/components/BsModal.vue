

<template>

    <div
        class="modal d-block bg-dark"
        @click.self="close"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        <fontawesome-icon :icon="icon" />
                        {{ title }}
                    </h5>

                    <router-link :to="closeRoute">
                        <fontawesome-icon icon="close" />
                    </router-link>

                </div>

                <div class="modal-body">
                    <slot />
                </div>

                <div class="modal-footer d-flex justify-content-between">

                    <div>
                        <slot name="footer-left" />
                    </div>

                    <div>

                        <router-link
                            :to="closeRoute"
                            class="btn btn-secondary"
                        >
                            <fontawesome-icon icon="close" />
                            {{ $t('actions.cancel') }}
                        </router-link>

                        <slot name="footer-right" />

                    </div>

                </div>

            </div>
        </div>
    </div>

</template>



<script>

    export default {
        props: {
            closeRoute: {
                type: Object,
                required: true,
            },
            icon: {
                type: String,
                required: true,
            },
            title: {
                type: String,
                required: true,
            },
        },
        mounted() {
            document.body.classList.add('modal-open');
            const autofocus = this.$el.querySelector('[autofocus]');
            if (autofocus) {
                autofocus.focus();
            }
        },
        beforeDestroy() {
            document.body.classList.remove('modal-open');
        },
        methods: {
            close() {
                this.$router.push(this.closeRoute);
            },
        },
    };

</script>
