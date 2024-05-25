@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard Inmoenergy</h1>
@stop

@section('content')
<p>create formality</p>
<div>
    {{html()->form('POST', route('admin.formality.store'))->class('form-horizontal')->open()}}
    {{ html()->email('email')->placeholder('Your e-mail address') }}
    {{html()->form()->close()}}
</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop