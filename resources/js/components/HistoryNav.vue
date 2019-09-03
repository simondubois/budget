
<template>

    <ul class="nav nav-tabs">

        <li class="nav-item">
            <a
                :class="{ active: period === 'latest' }"
                class="nav-link"
                href
                @click.prevent="setPeriod('latest')"
            >
                {{ $t('history.period.latest') }}
            </a>
        </li>

        <li class="nav-item">
            <a
                :class="{ active: period === 'monthly' }"
                class="nav-link"
                href
                @click.prevent="setPeriod('monthly')"
            >
                {{ $t('history.period.monthly') }}
            </a>
        </li>

        <li class="nav-item">
            <a
                :class="{ active: period === 'yearly' }"
                class="nav-link"
                href
                @click.prevent="setPeriod('yearly')"
            >
                {{ $t('history.period.yearly') }}
            </a>
        </li>

        <li
            v-if="period === 'monthly'"
            class="nav-item mt-3 ml-auto"
        >
            <a
                :class="{ invisible: isMinDate }"
                href
                @click.prevent="setPreviousDate"
            >
                <fontawesome-icon icon="previous" />
            </a>

            {{ dateLabel }}

            <a
                :class="{ invisible: isMaxDate }"
                href
                @click.prevent="setNextDate"
            >
                <fontawesome-icon icon="next" />
            </a>

        </li>

    </ul>

</template>



<script>

    export default {
        props: {
            entity: {
                type: String,
                required: true,
            },
        },
        computed: {
            dateLabel: vue => vue.$store.getters[vue.entity + 'History/dateLabel'],
            isMaxDate: vue => vue.$store.getters[vue.entity + 'History/isMaxDate'],
            isMinDate: vue => vue.$store.getters[vue.entity + 'History/isMinDate'],
            period: vue => vue.$store.getters[vue.entity + 'History/period'],
        },
        methods: {
            setNextDate() {
                this.$store.dispatch(this.entity + 'History/nextDate')
            },
            setPeriod(period) {
                this.$store.dispatch(this.entity + 'History/period', period);
            },
            setPreviousDate() {
                this.$store.dispatch(this.entity + 'History/previousDate')
            },
        },
    };

</script>
