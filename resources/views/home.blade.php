<!doctype html>

<html lang="{{ env('APP_LOCALE') }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="default-currency" content='@json(App\Currency::find(env('BUDGET_DEFAULT_CURRENCY')))''>
        <meta name="start-date" content="{{ App\Operation::min('date') ?? Carbon\Carbon::today() }}">
        <meta name="theme-color" content="#FFF">
        <link rel="icon" href="logo-large.png" />
        <link rel="manifest" href="/manifest.json" crossorigin="use-credentials">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <title>{{ env('APP_NAME') }}</title>
    </head>

    <body class="bg-light">

        <div id="app">

            <bs-navbar>
                <router-view name="navbar"></router-view>
            </bs-navbar>

            <transition name="fade">
                <help-onboarding
                    v-if="loaded"
                    class="my-4"
                ></help-onboarding>
            </transition>

            <transition
                mode="out-in"
                name="fade"
                appear
            >
                <router-view class="my-4"></router-view>
            </transition>

        </div>

        <script src="{{ mix('/js/app.js') }}"></script>

    </body>

</html>
