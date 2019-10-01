
<template>

    <router-link :to="{ name: 'envelope-show', params: { envelopeId: id } }">
        <fontawesome-icon :raw-icon="icon" />
        {{ name }}
    </router-link>

</template>



<script>

    export default {
        props: {
            envelope: {
                type: Object,
                required: true,
            },
        },
        computed: {
            icon: vue => vue.envelope.icon,
            id: vue => vue.envelope.id,
            name: vue => vue.envelope.name,
        },
    };

</script>
