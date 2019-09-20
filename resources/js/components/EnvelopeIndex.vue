
<template>

    <div class="container-fluid">
        <div class="row">

            <div class="d-none d-sm-block col-sm-4 col-xl-2">
                <envelope-list class="list-group-flush">
                    <router-link
                        slot="footer"
                        :to="{ name: 'envelope-create' }"
                        class="list-group-item list-group-item-action"
                    >
                        <span class="flex-fill text-truncate mr-1">
                            <fontawesome-icon icon="create" />
                            {{ $t('envelope.create.name') }}
                        </span>
                    </router-link>
                </envelope-list>
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
