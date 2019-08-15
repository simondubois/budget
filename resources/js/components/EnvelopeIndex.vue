
<template>

    <div class="container-fluid">
        <div class="row">

            <div class="d-none d-sm-block col-sm-4 col-xl-2">
                <envelope-list class="list-group-flush" />
            </div>

            <div class="col-sm-8 col-xl-10">
                <transition
                    mode="out-in"
                    name="fade"
                    appear
                >
                    <router-view />
                </transition>
            </div>

        </div>
    </div>

</template>



<script>

    export default {
    };

</script>
