
<template>

    <div class="card border-0">

        <div
            v-if="$slots.header"
            class="card-header border-0 bg-transparent"
        >
            <h2>
                <slot name="header" />
            </h2>
        </div>

        <div
            v-if="$slots['header-left'] || $slots['header-right']"
            class="card-header border-0 bg-transparent"
        >
            <h2 class="d-flex flex-wrap align-items-end">

                <div class="mr-1">
                    <slot name="header-left" />
                </div>

                <div class="flex-fill text-right">
                    <slot name="header-right" />
                </div>

            </h2>
        </div>

        <div
            v-if="$slots.list"
            class="list-group list-group-flush"
        >
            <slot name="list" />
        </div>

        <div
            v-if="$slots.body"
            class="card-body"
        >
            <slot name="body" />
        </div>

    </div>

</template>
