<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lenders Consulting</title>

</head>

<body>
    @extends('adminlte::auth.login')
</body>
<style>

    .login-logo b {
        color: var(--btn-success-bg) !important;
    }

</style>
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
</html>