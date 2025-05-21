<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')

</head>

<body>
    @include('components.web.header')


    {{$slot}}
    @include('components.web.footer')
</body>

</html>
