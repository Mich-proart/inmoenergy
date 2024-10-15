@props([
    'align' => 'left',
    'width' => '',
])

@php
    $textAlignClass = App\Domain\Common\TextAlignment::className($align);
@endphp


<td class="{{ $textAlignClass }}" style="width: {{$width}}">
    {{ $slot }}
</td>