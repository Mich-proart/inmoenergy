@aware([
    'error'
])

@props([
    'value',
    'name',
    'for'
])

<input {{ $attributes->class([
    'form-control',
    'is-invalid' => $error
]) }} @isset($name) name="{{ $name }}" @endisset
    type="text" @isset($id) id="{{ $id }}" @endisset @isset($value) value="{{ $value }}" @endisset {{ $attributes }}>