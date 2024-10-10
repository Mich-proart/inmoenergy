@props([
    'align' => 'left',
])

@php
    $textAlignClass = App\Domain\Common\TextAlignment::className($align);
@endphp


<td class="{{ $textAlignClass }}">
    {{ $slot }}
</td>