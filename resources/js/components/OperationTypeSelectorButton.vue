
<template>

    <label
        :class="classes"
        :title="$t('operation.types.' + name)"
        class="btn btn-secondary"
    >

        <input
            :disabled="disabled"
            :type="type"
            :value="name"
            @click="click"
        >

        <fontawesome-icon :icon="name" />

        <template v-if="showLabel">
            {{ $t('operation.types.' + name) }}
        </template>

    </label>

</template>



<script>

    export default {
        props: {
            checked: {
                type: Boolean,
                required: true,
            },
            context: {
                type: String,
                required: true,
            },
            disabled: {
                type: Boolean,
                required: true,
            },
            multiple: {
                type: Boolean,
                required: true,
            },
            name: {
                type: String,
                required: true,
            },
            showLabel: {
                type: Boolean,
                required: true,
            },
        },
        computed: {
            type: vue => vue.multiple ? 'checkbox' : 'radio',
            classes: vue => ({
                active: vue.checked,
                ['btn-outline-' + vue.context]: true,
                disabled: vue.disabled,
            }),
        },
        methods: {
            click() {
                this.$emit(this.checked ? 'uncheck' : 'check');
            }
        }
    };

</script>
