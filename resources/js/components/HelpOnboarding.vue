
<template>

    <div
        v-if="uncomplete"
        class="d-flex justify-content-center"
    >
        <div class="mb-0 alert alert-warning">

            {{ $t('help.onboarding.introduction') }}

            <ul class="fa-ul mb-0">

                <li>

                    <span class="fa-li">
                        <fontawesome-icon :icon="hasCurrency ? 'done' : 'undone'" />
                    </span>

                    <a
                        href="https://github.com/simondubois/budget/blob/master/readme.md#deployment"
                        class="text-white"
                        target="blank"
                    >
                        <component :is="hasCurrency ? 's' : 'u'">
                            {{ $t('help.onboarding.currency') }}
                        </component>
                    </a>

                </li>

                <li>

                    <span class="fa-li">
                        <fontawesome-icon :icon="hasDefaultCurrency ? 'done' : 'undone'" />
                    </span>

                    <a
                        href="https://github.com/simondubois/budget/blob/master/readme.md#deployment"
                        class="text-white"
                        target="blank"
                    >
                        <component :is="hasDefaultCurrency ? 's' : 'u'">
                            {{ $t('help.onboarding.defaultCurrency') }}
                        </component>
                    </a>

                </li>

                <li>

                    <span class="fa-li">
                        <fontawesome-icon :icon="hasAccount ? 'done' : 'undone'" />
                    </span>

                    <router-link
                        :to="{ name: 'account-create' }"
                        class="text-white"
                    >
                        <component :is="hasAccount ? 's' : 'u'">
                            {{ $t('help.onboarding.account') }}
                        </component>
                    </router-link>

                </li>

                <li>

                    <span class="fa-li">
                        <fontawesome-icon :icon="hasEnvelope ? 'done' : 'undone'" />
                    </span>

                    <router-link
                        :to="{ name: 'envelope-create' }"
                        class="text-white"
                    >
                        <component :is="hasEnvelope ? 's' : 'u'">
                            {{ $t('help.onboarding.envelope') }}
                        </component>
                    </router-link>

                </li>

            </ul>

        </div>
    </div>

</template>



<script>

    export default {
        computed: {
            hasAccount: vue => vue.$store.getters['account/all'].length > 0,
            hasCurrency: vue => vue.$store.getters['currency/all'].length > 0,
            hasDefaultCurrency: vue => vue.$store.getters['currency/selected'],
            hasEnvelope: vue => vue.$store.getters['envelope/all'].length > 0,
            uncomplete: vue => !vue.hasAccount || !vue.hasCurrency || !vue.hasDefaultCurrency || !vue.hasEnvelope,
        },
    };

</script>
