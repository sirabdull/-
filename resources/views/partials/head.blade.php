<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />


<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
@if(!str_starts_with(request()->path(), 'admin'))
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endif


@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    [x-clock] {
        display: none
    }
</style>
@fluxAppearance
