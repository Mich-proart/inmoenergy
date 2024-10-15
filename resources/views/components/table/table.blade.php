@props([
    'align' => 'left',
    'width' => '',
])

<table class="table table-hover table-sm">
    <thead>
        <tr>
            @foreach ($headers as $header)
                <th scope="col" class="{{ $header['classes'] }}" style="width: {{$width}}">
                    {{ $header['name'] }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>