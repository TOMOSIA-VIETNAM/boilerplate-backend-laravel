@props(['dir'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }} | Admin Dashboard</title>

    @vite(['modules/Admin/resources/assets/css/app.css', 'modules/Admin/resources/assets/js/app.js'])
    @include('admin::partials._head')
</head>

<body class="">
    @include('admin::partials._body')
</body>

</html>
