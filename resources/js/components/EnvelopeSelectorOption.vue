
<template>

    <option :value="id">
        {{ name }}
    </option>

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
            id: vue => vue.envelope.id,
            name: vue => vue.envelope.name,
        },
    };

</script>
