@extends('adminlte::page')

@section('title', 'Dashboard')

@section('meta_tags')
<meta name="version" content="{{ config('app.version') }}">
@stop

@section('content_header')
<h1>Dashboard Inmoenergy</h1>
@stop

@section('content')
<p>show roles list</p>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop